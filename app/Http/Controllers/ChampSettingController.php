<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Xoco70\LaravelTournaments\Exceptions\TreeGenerationException;
use Xoco70\LaravelTournaments\Models\Championship;
use Xoco70\LaravelTournaments\Models\ChampionshipSettings;
use Xoco70\LaravelTournaments\Models\FightersGroup;
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

        // Skip preliminary round jika diatur
        if ($champ->hasPreliminary()) {
            $groupsQuery->where('round', '>', 1);
        }

        $groups = $groupsQuery->get();

        foreach ($groups as $group) {
            foreach ($group->fights as $fight) {
                // Set player A
                $fight->c1 = $competitors[$numFighter] ?? null;
                $fight->winner_id = $this->getWinnerId($competitors, $scores, $numFighter);
                $numFighter++;

                // Set player B
                $fight->c2 = $competitors[$numFighter] ?? null;

                // Jika belum ada pemenang dari sisi A, coba cek sisi B
                if ($fight->winner_id === null) {
                    $fight->winner_id = $this->getWinnerId($competitors, $scores, $numFighter);
                }
                $numFighter++;

                $fight->save();

                if ($fight->winner_id) {
                    $this->advanceWinnerToNextRound($fight, $group);
                }
            }
        }

        return back()->with('success', 'Hasil pertarungan berhasil diperbarui.');
    }


    public function getWinnerId($fighters, $scores, $numFighter)
    {
        return $scores[$numFighter] != null ? $fighters[$numFighter] : null;
    }

    public function buildMatches(Championship $champ)
    {
        $matches = [];
        $fights = Fight::whereHas('group', function ($query) use ($champ) {
                $query->where('championship_id', $champ->id);
            })
            ->orderBy('id')
            ->get();

        $index = 0;

        foreach ($fights as $fight) {
            $matches[] = [
                'playerA' => $fight->c1 ? Competitor::find($fight->c1) : null,
                'playerB' => $fight->c2 ? Competitor::find($fight->c2) : null,
                'winner_id' => $fight->winner_id,
                'indexA' => $index,
                'indexB' => $index + 1,
                'matchWrapperTop' => 100 * ($index / 2), // atau pakai posisi dari group jika ada
                'matchWrapperLeft' => 200 * ($fight->group->round ?? 1), // misalnya round = 1,2,3
            ];

            $index += 2;
        }

        return $matches;
    }

    protected function advanceWinnerToNextRound($fight, FightersGroup $group)
    {
        $nextRound = $group->round + 1;
        $nextOrder = floor($group->order / 2);

        $nextGroup = FightersGroup::where('championship_id', $group->championship_id)
            ->where('round', $nextRound)
            ->where('area', $group->area)
            ->where('order', $nextOrder)
            ->with('fights')
            ->first();

        if (!$nextGroup) {
            return;
        }

        $nextFight = $nextGroup->fights->first();

        if (!$nextFight) {
            return;
        }

        // Tentukan posisi (c1 atau c2) berdasarkan order
        if ($group->order % 2 === 0) {
            // Jangan timpa c1 kalau sudah terisi
            if (!$nextFight->c1) {
                $nextFight->c1 = $fight->winner_id;
            }
        } else {
            // Jangan timpa c2 kalau sudah terisi
            if (!$nextFight->c2) {
                $nextFight->c2 = $fight->winner_id;
            }
        }

        $nextFight->save();
    }

}


