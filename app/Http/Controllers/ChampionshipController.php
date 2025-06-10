<?php

namespace App\Http\Controllers;

// use App\Models\Championship;
use Xoco70\LaravelTournaments\Models\Championship;
use Xoco70\LaravelTournaments\Models\ChampionshipSettings;
use Xoco70\LaravelTournaments\Models\Competitor;
use Xoco70\LaravelTournaments\Models\Tournament;
// use App\Models\Tournament;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ChampionshipController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $tour = Tournament::where('user_id', auth()->user()->id)->get();
        $champs = Championship::with(['tournament', 'category'])->get();


        return view('dashboard.champs.index',[
            'champs' => $champs
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.champs.create', [
            'categories' => Category::all(),
            'tours' => Tournament::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tournament_id' => 'required|exists:tournament,id',
            'category_id' => 'required|exists:category,id',
            'hasPreliminary' => 'required|in:0,1',
            'preliminaryGroupSize' => 'nullable|in:3,4,5|required_if:hasPreliminary,1',
            // 'preliminaryGroupSize' => 'required_if:hasPreliminary,1|in:3,4,5',
            'numFighters' => 'required|integer|min:4|max:128',
            'isTeam' => 'required|in:0,1',
            'treeType' => 'required|in:0,1',
            'fightingAreas' => 'required|in:1,2,4,8',
        ]);

        // Simpan Championship utama
        $championship = Championship::create([
            'tournament_id' => $validated['tournament_id'],
            'category_id' => $validated['category_id'],
        ]);

        // Simpan setting terkait
        ChampionshipSettings::create([
            'championship_id' => $championship->id,
            'hasPreliminary' => $validated['hasPreliminary'],
            'preliminaryGroupSize' => $validated['hasPreliminary'] ? $validated['preliminaryGroupSize'] : null,
            // 'preliminaryGroupSize' => $validated['preliminaryGroupSize'],
            'numFighters' => $validated['numFighters'],
            'isTeam' => $validated['isTeam'],
            'treeType' => $validated['treeType'],
            'fightingAreas' => $validated['fightingAreas'],
        ]);

        return redirect('/dashboard/champs')->with('success', 'Championship berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Championship $championship)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Championship $champ)
    {
        return view('dashboard.champs.edit', [
            'champ' => $champ,
            'tours' => Tournament::all(),
            'categories' => Category::all(),
            'users' => User::all(),
            'comps' => Competitor::all()
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Championship $champ)
    {
        $validatedData = $request->validate([
            'tournament_id'     => 'required|exists:tournament,id',
            'category_id'       => 'required|exists:category,id'
        ]);

        Championship::where('id', $champ->id)->update($validatedData);

        return redirect('/dashboard/champs')->with('success', 'Championship diperbarui!');


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Championship $champ)
    {
        $champ->delete();

        return redirect('/dashboard/champs')->with('success', 'Championship telah dihapus!');
    }
}
