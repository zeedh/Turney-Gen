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

        $tournament = Tournament::whereHas('championships', function ($query) use ($champ) {
            $query->where('id', $champ->id)
                ->where('category_id', $champ->category_id);
        })
        ->with([
            'competitors',
            'championships.settings',
            'championships.category'
        ])
        ->first();

        $winners = $this->getWinners($champ);

        return view('dashboard.champs.setting.index', [
            'champ' => $champ,
            'competitorCount' => $competitorCount,
            'tournament' => $tournament,
            "active" => 'blog',
            'champion' => $winners['champion'],
            'runnerUp' => $winners['runnerUp'],
            'thirdPlace' => $winners['thirdPlace']
        ]);
    }

    public function store(Request $request, Championship $champ)
    {
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
            // ->route('dashboard.setting.index', $champ->id)
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

                // Skip jika fight di round 1 tapi masih kosong (c1 dan c2 null)
                if ($group->round == 1 && !$fight->c1 && !$fight->c2) {
                    $numFighter += 2;
                    continue;
                }

                $scoreC1 = $scores[$numFighter] ?? null;
                $c1 = $competitors[$numFighter] ?? $fight->c1;
                $numFighter++;

                $scoreC2 = $scores[$numFighter] ?? null;
                $c2 = $competitors[$numFighter] ?? $fight->c2;
                $numFighter++;

                // Jangan timpa jika sudah ada
                $fight->c1 = $fight->c1 ?? $c1;
                $fight->c2 = $fight->c2 ?? $c2;

                $fight->score_c1 = $scoreC1;
                $fight->score_c2 = $scoreC2;

                // Tentukan pemenang jika ada skor
                $fight->winner_id = $this->getWinnerId($fight);

                $fight->save();

                // Lanjutkan winner ke next round
                if ($fight->winner_id) {
                    $this->advanceWinnerToNextRound($fight, $group);

                    // Isi fight perebutan juara 3 jika semifinal
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

    public function getWinnerId($fight)
    {
        if ($fight->score_c1 !== null && $fight->score_c2 !== null) {
            if ($fight->score_c1 > $fight->score_c2) {
                return $fight->c1;
            } elseif ($fight->score_c2 > $fight->score_c1) {
                return $fight->c2;
            }
        }

        return null;
    }


    protected function advanceWinnerToNextRound($fight, FightersGroup $group)
    {
        $currentRound = (int) $group->round;
        $nextRound = $currentRound + 1;

        $nextOrder = ($group->order % 2 == 1)
            ? intdiv($group->order + 1, 2)
            : intdiv($group->order, 2);

        $nextGroup = FightersGroup::where('championship_id', $group->championship_id)
            ->where('round', $nextRound)
            ->where('area', $group->area)
            ->where('order', $nextOrder)
            ->with('fights')
            ->first();

        $nextFight = $nextGroup?->fights->first();

        if (!$nextFight || ($nextFight->c1 && $nextFight->c2) || $nextFight->winner_id) {
            return;
        }

        if (!$nextFight->c1) {
            $nextFight->c1 = $fight->winner_id;
        } elseif (!$nextFight->c2) {
            $nextFight->c2 = $fight->winner_id;
        }

        $nextFight->save();
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

    public function getWinners(Championship $champ)
    {
        $finalRound = FightersGroup::where('championship_id', $champ->id)->max('round');

        // Final: round terakhir, order = 1
        $finalFight = Fight::whereHas('group', function ($q) use ($champ, $finalRound) {
            $q->where('championship_id', $champ->id)
            ->where('round', $finalRound)
            ->where('order', 1);
        })->with(['winner', 'competitor1', 'competitor2'])->first();

        // Perebutan Juara 3: round terakhir, order = 2 (atau fight terakhir di round tsb selain final)
        $thirdPlaceFight = Fight::whereHas('group', function ($q) use ($champ, $finalRound) {
            $q->where('championship_id', $champ->id)
            ->where('round', $finalRound);
        })->with('winner')->latest('id')->first();

        // Tentukan Juara
        $champion = $finalFight?->winner;
        $runnerUp = null;
        if ($finalFight && $finalFight->c1 && $finalFight->c2 && $finalFight->winner_id) {
            $runnerUp = $finalFight->winner_id == $finalFight->c1
                ? $finalFight->competitor2
                : $finalFight->competitor1;
        }

        $thirdPlace = $thirdPlaceFight?->winner;

        return compact('champion', 'runnerUp', 'thirdPlace');
    }


}


