<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Xoco70\LaravelTournaments\Models\Championship;
use Xoco70\LaravelTournaments\Models\Competitor;
use Xoco70\LaravelTournaments\Models\Tournament;
use Xoco70\LaravelTournaments\Models\FightersGroup;
use Xoco70\LaravelTournaments\Models\Fight;

class BaganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($champ)
    {
        // dd($champ);
        $champ = Championship::findOrFail($champ);

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

        return view('postTree.index', [
            "title" => "Bagan Pertandingan",
            "active" => 'blog',
            'champ' => $champ,
            'competitorCount' => $competitorCount,
            'tournament' => $tournament,
            'champion' => $winners['champion'],
            'runnerUp' => $winners['runnerUp'],
            'thirdPlace' => $winners['thirdPlace']
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
    public function store(Request $request)
    {
        //
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
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
