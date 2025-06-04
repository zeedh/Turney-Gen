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

class ChampSettingController extends Controller
{
    public function index(Championship $champ)
    {
        $competitorCount = Competitor::where('championship_id', $champ->id)->count();
        // dd($competitorCount);

        return view('dashboard.champs.setting.index', [
            'champ' => $champ,
            'competitorCount' => $competitorCount
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

            try {
                $generation = $champ->chooseGenerationStrategy();
                $generation->run();
            } catch (TreeGenerationException $e) {
                return redirect()->back()->withErrors($e->getMessage());
            }
        }

        return back()
            ->with('numFighters', $numFighters)
            ->with('isTeam', $isTeam);
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
        $competitors = $champ->competitors()->pluck('id')->toArray();
        $numFighter = 0;

        $query = FightersGroup::with('fights')
            ->where('championship_id', $champ->id);

        $scores = $request->score;

        if ($champ->hasPreliminary()) {
            $query = $query->where('round', '>', 1);
        }

        $groups = $query->get();

        foreach ($groups as $group) {
            foreach ($group->fights as $fight) {
                $fight->c1 = $competitors[$numFighter] ?? null;
                $fight->winner_id = $this->getWinnerId($competitors, $scores, $numFighter);
                $numFighter++;

                $fight->c2 = $competitors[$numFighter] ?? null;
                if ($fight->winner_id === null) {
                    $fight->winner_id = $this->getWinnerId($competitors, $scores, $numFighter);
                }
                $numFighter++;

                $fight->save();
            }
        }

        return back();
    }


    public function getWinnerId($fighters, $scores, $numFighter)
    {
        return $scores[$numFighter] != null ? $fighters[$numFighter] : null;
    }
}


