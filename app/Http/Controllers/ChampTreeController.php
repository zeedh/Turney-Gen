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

class ChampTreeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Championship $champ, ChampionshipSettings $setting)
    {
        // Pastikan pengaturan yang dikirim sesuai dengan championship
        if ($setting->championship_id !== $champ->id) {
            abort(404);
        }

        // Ambil data yang dibutuhkan
        $isTeam = session('isTeam', 0);
        $numFighters = session('numFighters', $champ->competitors->count());
        $fights = $champ->fights;
        $fightersGroups = $champ->fightersGroups;

        // Cek apakah tree sudah digenerate
        $hasTree = $fightersGroups()->exists();

        return view('dashboard.champs.setting.tree.index', [
            'champ' => $champ,
            'setting' => $setting,
            'isTeam' => $isTeam,
            'numFighters' => $numFighters,
            'hasTree' => $hasTree,
            'fights' => $fights,
            'fightersGroups' => $fightersGroups
        ]);
    }

    public function generateTree(Request $request, Championship $champ)
    {
        $setting = $champ->getSettings();

        if (!$setting) {
            return redirect()->back()->withErrors('Pengaturan belum disimpan.');
        }

        $validatedData = $setting->toArray();
        $validatedData['numFighters'] = session('numFighters', $champ->competitors->count());
        $validatedData['isTeam'] = session('isTeam', 0);

        try {
            // Hapus data lama jika sudah ada tree
            if ($champ->fightersGroups()->exists()) {
                $this->clearTreeData($champ);
            }

            $champ = $this->provisionObjects($validatedData, $champ);

            $generation = $champ->chooseGenerationStrategy();
            $generation->run();

            return redirect()->back()->with('success', 'Tree berhasil digenerate ulang!');
        } catch (TreeGenerationException $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
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
}
