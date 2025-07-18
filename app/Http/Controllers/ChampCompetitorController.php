<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Xoco70\LaravelTournaments\Models\Competitor;
use Xoco70\LaravelTournaments\Models\Championship;
use Xoco70\LaravelTournaments\Models\Tournament;
use App\Models\User;
use Illuminate\Support\Str;

class ChampCompetitorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Championship $champ)
    {
        $competitors = Competitor::where('championship_id', $champ->id)->with('championship')->get();
        // $competitors = Competitor::where('championship_id', $champ->id)
        //                 ->with('user')
        //                 ->orderBy('seed')
        //                 ->paginate(8)
        //                 ->withQueryString();

        $search = request('search');

        $limit = $champ->settings->limitByEntity ?? null;
    
        $users = User::query()
            ->when($search, function ($query, $search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('name', 'like', '%' . $search . '%')
                            ->orWhere('email', 'like', '%' . $search . '%');
                });
            })
            ->paginate(5)
            ->withQueryString();

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

        return view('dashboard.champs.competitors.index',[
            'competitors' => $competitors,
            'tournament' => $tournament,
            'champ' => $champ,
            'users' => $users,
            "active" => 'blog',
            'limit' => $limit
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
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id'
        ]);

        // Ambil setting untuk championship ini
        $setting = $champ->settings()->first();

        if (!$setting) {
            return back()->with('error', 'Pengaturan kejuaraan belum dibuat.');
        }

        $limit = $setting->limitByEntity ?? 0;

        $currentCount = Competitor::where('championship_id', $champ->id)->count();

        if ($limit > 0 && $currentCount >= $limit) {
            return back()->with('error', 'Jumlah peserta sudah mencapai batas maksimum.');
        }

        // Cek apakah user sudah terdaftar
        $exists = Competitor::where('championship_id', $champ->id)
            ->where('user_id', $validated['user_id'])
            ->exists();

        if ($exists) {
            return back()->with('error', 'User sudah terdaftar sebagai peserta.');
        }

        Competitor::create([
            'user_id' => $validated['user_id'],
            'championship_id' => $champ->id,
            'confirmed' => false,
            'short_id' => random_int(1, 200),
        ]);

        return redirect()
            ->route('dashboard.competitors.index', $champ->id)
            ->with('success', 'Peserta berhasil ditambahkan!');


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
    public function update(Request $request, Championship $champ, Competitor $competitor = null)
    {
        // $seeds = $request->input('seeds', []);

        // foreach ($seeds as $competitorId => $seed) {
        //     Competitor::where('id', $competitorId)
        //         ->where('championship_id', $champ->id)
        //         ->update(['seed' => $seed]);
        // }

        // return redirect()->route('dashboard.competitors.index', $champ->id)->with('success', 'Seed peserta berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Championship $champ, Competitor $competitor)
    {
        $competitor->delete();

        return redirect()->route('dashboard.competitors.index', $champ->id)->with('success', 'Peserta berhasil dihapus.');

    }

    public function editSeed(Championship $champ)
    {
        // Pastikan tournament-nya ikut dimuat
        $champ->load('tournament');

        $competitors = Competitor::where('championship_id', $champ->id)
            ->with('user')
            ->orderBy('seed')
            ->get();
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

        return view('dashboard.champs.competitors.seed.edit', [
            'champ' => $champ,
            'competitors' => $competitors,
            'tournament' => $tournament
        ]);
    }

    public function saveSeed(Request $request, Championship $champ)
    {
        $seeds = $request->input('seeds', []);

        foreach ($seeds as $id => $value) {
            Competitor::where('id', $id)
                ->where('championship_id', $champ->id)
                ->update(['seed' => $value]);
        }

        return redirect()->route('dashboard.competitors.seed.edit', $champ->id)->with('success', 'Seed berhasil diperbarui!');
    }


}
