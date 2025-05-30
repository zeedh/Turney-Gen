<?php

namespace App\Http\Controllers;

// use App\Models\Championship;
use Xoco70\LaravelTournaments\Models\Championship;
use App\Models\Tournament;
use App\Models\Category;
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
        $validatedData = $request->validate([
            'tournament_id'     => 'required|exists:tournament,id',
            'category_id'       => 'required|exists:category,id'
        ]);

        // $validatedData['user_id'] = auth()->user()->id;

        Championship::create($validatedData);

        return redirect('/dashboard/champs')->with('success', 'Championship Baru telah dibuat!');
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
    public function edit(Request $request, Championship $champs)
    {
        return view('dashboard.champs.edit', [
            'champs' => $champs,
            'tours' => Tournament::all(),
            'categories' => Category::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Championship $champs)
    {
        $validatedData = $request->validate([
            'tournament_id'     => 'required|exists:tournament,id',
            'category_id'       => 'required|exists:category,id'
        ]);

        Championship::where('id', $champs->id)->update($validatedData);

        return redirect('/dashboard/champs')->with('success', 'Championship Baru telah dibuat!');


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Championship $championship)
    {
        //
    }
}
