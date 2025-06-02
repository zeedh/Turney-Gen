<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Xoco70\LaravelTournaments\Exceptions\TreeGenerationException;
use Xoco70\LaravelTournaments\Models\Championship;
use Xoco70\LaravelTournaments\Models\ChampionshipSettings;
use Xoco70\LaravelTournaments\Models\Competitor;
use Xoco70\LaravelTournaments\Models\FightersGroup;
use Xoco70\LaravelTournaments\Models\Team;

class ChampSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Championship $champ)
    {
        return view('dashboard.champs.setting.index',[
            'champ' => $champ
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Championship $champ)
    {
        // Tambahkan championship_id secara eksplisit
        $validatedData = $this->validateRequest($request);
        $validatedData['championship_id'] = $champ->id;

        // Simpan pengaturan
        ChampionshipSettings::updateOrCreate(
            ['championship_id' => $champ->id],
            $validatedData
        );

        $numFighters = $validatedData['numFighters'];
        $isTeam = $validatedData['isTeam'];

        // Generate tree
        $championship = $this->provisionObjects($validatedData, $champ);
        $generation = $champ->chooseGenerationStrategy();

        try {
            $generation->run();
        } catch (TreeGenerationException $e) {
            return redirect()->back()->withErrors($e->getMessage());
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


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Championship $championship)
    {
                $numFighter = 0;
        $query = FightersGroup::with('fights')
            ->where('championship_id', $championship->id);

        $fighters = $request->singleElimination_fighters;
        $scores = $request->score;
        if ($championship->hasPreliminary()) {
            $query = $query->where('round', '>', 1);
            $fighters = $request->preliminary_fighters;
        }
        $groups = $query->get();

        foreach ($groups as $group) {
            foreach ($group->fights as $fight) {
                $fight->c1 = $fighters[$numFighter];
                $fight->winner_id = $this->getWinnerId($fighters, $scores, $numFighter);
                $numFighter++;

                $fight->c2 = $fighters[$numFighter];
                if ($fight->winner_id == null) {
                    $fight->winner_id = $this->getWinnerId($fighters, $scores, $numFighter);
                }
                $numFighter++;
                $fight->save();
            }
        }

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

        public function getWinnerId($fighters, $scores, $numFighter)
    {
        return $scores[$numFighter] != null ? $fighters[$numFighter] : null;
    }
}
