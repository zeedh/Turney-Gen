<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Xoco70\LaravelTournaments\Exceptions\TreeGenerationException;
use Xoco70\LaravelTournaments\Models\Championship;
use Xoco70\LaravelTournaments\Models\ChampionshipSettings;
use Xoco70\LaravelTournaments\Models\FightersGroup;
use Xoco70\LaravelTournaments\Models\Fight;
use Xoco70\LaravelTournaments\Models\Competitor;
use Xoco70\LaravelTournaments\Models\Tournament;
// use App\Models\Tournament;

class ChampSettingController extends Controller
{
    public function index(Championship $champ)
    {
        $competitorCount = Competitor::where('championship_id', $champ->id)->count();

        // Ambil tournament yang terkait dengan championship ini
        $tournament = Tournament::whereHas('championships', function ($query) use ($champ) {
            $query->where('id', $champ->id)
                ->where('category_id', $champ->category_id);
        })
        ->with([
            'competitors',
            'championships.settings',
            'championships.category'
        ])
        ->first(); // Ambil satu tournament terkait

        return view('dashboard.champs.setting.index', [
            'champ' => $champ,
            'competitorCount' => $competitorCount,
            'tournament' => $tournament
        ]);
    }

    public function store(Request $request, Championship $champ)
    {
        // Validasi input
        $validatedData = $this->validateRequest($request);
        $validatedData['championship_id'] = $champ->id;

        // Simpan atau perbarui pengaturan
        ChampionshipSettings::updateOrCreate(
            ['championship_id' => $champ->id],
            $validatedData
        );

        $numFighters = $validatedData['numFighters'];
        $isTeam = $validatedData['isTeam'];

        // Generate tree hanya jika belum ada tree sebelumnya
        if ($champ->fightersGroups()->count() === 0) {
            $champ = $this->provisionObjects($validatedData, $champ);
            $champ->refresh(); // Paksa ambil ulang data dari DB

            try {
                $generation = $champ->chooseGenerationStrategy();
                $generation->run();
            } catch (TreeGenerationException $e) {
                return redirect()->back()->withErrors($e->getMessage());
            }
        } else {
            // Jika sudah ada, bersihkan tree lama lalu regenerate
            $this->clearTreeData($champ);

            $champ = $this->provisionObjects($validatedData, $champ);
            $champ->refresh(); // Paksa ambil ulang data dari DB

            try {
                $generation = $champ->chooseGenerationStrategy();
                $generation->run();
            } catch (TreeGenerationException $e) {
                return redirect()->back()->withErrors($e->getMessage());
            }
        }

        return back()
            // ->route('setting.index', $champ->id)
            ->with('success', 'Pengaturan berhasil disimpan.')
            ->with('numFighters', $validatedData['numFighters'])
            ->with('isTeam', $validatedData['isTeam']);
            // ->with('numFighters', $numFighters)
            // ->with('isTeam', $isTeam);
    }

    protected function validateRequest(Request $request): array
    {
        return $request->validate([
            'hasPreliminary' => 'required|in:0,1',
            'preliminaryGroupSize' => 'nullable|in:3,4,5',
            'numFighters' => 'required|integer|min:4|max:128',
            'isTeam' => 'required|in:0,1',
            'treeType' => 'required|in:0,1',
            'fightingAreas' => 'required|in:1,2,4,8',
        ]);
    }

    protected function provisionObjects(array $data, Championship $champ)
    {
        $champ->settings = ChampionshipSettings::createOrUpdate($data, $champ);
        return $champ;
    }

    protected function clearTreeData(Championship $champ)
    {
        // Ambil semua fighters group ID berdasarkan championship ini
        $groupIds = FightersGroup::where('championship_id', $champ->id)->pluck('id');

        if ($groupIds->isEmpty()) {
            return;
        }

        // Hapus entri pivot (relasi group dengan competitor)
        DB::table('fighters_group_competitor')
            ->whereIn('fighters_group_id', $groupIds)
            ->delete();

        // Hapus semua fight yang terkait group tersebut
        DB::table('fight')
            ->whereIn('fighters_group_id', $groupIds)
            ->delete();

        // Hapus group-nya
        FightersGroup::whereIn('id', $groupIds)->delete();
    }

    public function update(Request $request, Championship $champ)
    {
        $scores = $request->input('score', []);
        $competitors = $champ->competitors()->pluck('id')->toArray();
        $numFighter = 0;

        $groupsQuery = FightersGroup::with('fights')
            ->where('championship_id', $champ->id);

        // Skip preliminary jika ada pengaturan
        if ($champ->hasPreliminary()) {
            $groupsQuery->where('round', '>', 1);
        }

        $groups = $groupsQuery->get();
        $finalRound = FightersGroup::where('championship_id', $champ->id)->max('round');

        foreach ($groups as $group) {
            foreach ($group->fights as $fight) {
                // Lewati jika fight sudah punya pemenang
                if ($fight->winner_id !== null) {
                    $numFighter += 2;
                    continue;
                }

                // Ambil skor
                $scoreC1 = $scores[$numFighter] ?? null;
                $c1 = $competitors[$numFighter] ?? $fight->c1;
                $numFighter++;

                $scoreC2 = $scores[$numFighter] ?? null;
                $c2 = $competitors[$numFighter] ?? $fight->c2;
                $numFighter++;

                // Jangan timpa jika sudah ada c1 atau c2
                $fight->c1 = $fight->c1 ?? $c1;
                $fight->c2 = $fight->c2 ?? $c2;

                // Simpan skor
                $fight->score_c1 = $scoreC1;
                $fight->score_c2 = $scoreC2;

                // Tentukan pemenang
                if ($scoreC1 !== null && $scoreC2 !== null) {
                    if ($scoreC1 > $scoreC2) {
                        $fight->winner_id = $fight->c1;
                    } elseif ($scoreC2 > $scoreC1) {
                        $fight->winner_id = $fight->c2;
                    }
                }

                $fight->save();

                // Jika sudah ada pemenang, teruskan ke next round
                if ($fight->winner_id) {
                    $this->advanceWinnerToNextRound($fight, $group);

                    // Jika fight ini adalah semifinal, langsung isi perebutan juara 3
                    if ($group->round === $finalRound - 1) {
                        $loserId = ($fight->winner_id == $fight->c1) ? $fight->c2 : $fight->c1;
                        if ($loserId) {
                            $this->fillThirdPlaceFight($champ, $loserId);
                        }
                    }
                }
            }
        }

        return back()->with('success', 'Hasil pertarungan berhasil diperbarui.');
    }


    public function getWinnerId($fighters, $scores, $numFighter)
    {
        return $scores[$numFighter] != null ? $fighters[$numFighter] : null;
    }

    protected function advanceWinnerToNextRound($fight, FightersGroup $group)
    {
        $nextRound = $group->round + 1;
        if ($group->order % 2 == 1) {
            $nextOrder = intdiv($group->order + 1, 2);
        }
        else {
            $nextOrder = floor($group->order / 2);
        }

        // $nextOrder = floor(($group->order - 1) / 2);

        // Ambil group untuk round berikutnya
        $nextGroup = FightersGroup::where('championship_id', $group->championship_id)
            ->where('round', $nextRound) // <-- Pastikan ini round selanjutnya
            ->where('area', $group->area)
            ->where('order', $nextOrder)
            ->with('fights')
            ->first();

        // Ambil fight pertama dari group tersebut
        $nextFight = $nextGroup?->fights->first();

        // Pastikan:
        // - Fight sekarang punya pemenang
        // - Next fight belum punya winner
        // - Next fight belum penuh
        if (!$nextFight || ($nextFight->c1 && $nextFight->c2) || $nextFight->winner_id) {
            return;
        }

        // Tambahkan pemenang ke slot kosong
        if (!$nextFight->c1) {
            $nextFight->c1 = $fight->winner_id;
        } elseif (!$nextFight->c2) {
            $nextFight->c2 = $fight->winner_id;
        }

        $nextFight->save();
    }


    public function updateSingleFight(Request $request, Championship $champ, $fightId)
    {
        $scores = $request->input('score', []);
        $fight = Fight::findOrFail($fightId);

        $competitorIds = $champ->competitors()->pluck('id')->toArray();

        // Cari c1 dan c2 dari kompetitor terdekat berdasarkan score
        $c1 = reset($scores);
        $c2 = next($scores);

        $fight->c1 = $c1 ?: null;
        $fight->c2 = $c2 ?: null;

        if ($c1 && isset($scores[key($scores)]) && $scores[key($scores)] == $c1) {
            $fight->winner_id = $c1;
        } elseif ($c2 && $scores[key($scores)] == $c2) {
            $fight->winner_id = $c2;
        } else {
            $fight->winner_id = null;
        }

        $fight->save();

        // Optional: Lanjutkan otomatis ke next round jika diperlukan
        $this->advanceWinnerToNextRound($fight, $champ);

        return back()->with('success', 'Pertandingan berhasil diperbarui.');
    }

    protected function fillThirdPlaceFight(Championship $champ, $loserId)
    {
        $finalRound = FightersGroup::where('championship_id', $champ->id)->max('round');

        // Cari group & fight perebutan juara 3
        $thirdPlaceGroup = FightersGroup::where('championship_id', $champ->id)
            ->where('round', $finalRound)
            ->where('order', 1)
            ->latest('id')
            ->first();

        if (!$thirdPlaceGroup || $thirdPlaceGroup->fights->isEmpty()) {
            return;
        }

        $fight = $thirdPlaceGroup->fights->first();

        // Cek apakah sudah ada isian
        if (!$fight->c1) {
            $fight->c1 = $loserId;
        } elseif (!$fight->c2 && $fight->c1 !== $loserId) {
            $fight->c2 = $loserId;
        }

        $fight->save();
    }


}


