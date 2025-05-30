<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tournament;
use App\Models\Category;
use App\Models\Championship;
use Illuminate\Http\Request;
use \Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
// use Xoco70\LaravelTournaments\Models\Tournament;

class DashboardTurneyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.tours.index', [
            'tours' => Tournament::where('user_id', auth()->user()->id)->get() //TODO Jangan lupa ganti ke turnamen!!
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.tours.create', [
            'categories' => Category::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([

            'name'              => 'required|max:255',
            'slug'              => 'required|unique:tournament',
            'dateIni'           => "required|date",
            'dateFin'           => "required|date|after_or_equal:dateIni",
            'registerDateLimit' => "nullable|date|before_or_equal:dateFin",
            'sport'             => 'nullable|in:1', // atau biarkan di-set langsung, tidak lewat request
            'type'              => 'nullable|in:0',
            'level_id'          => 'nullable|exists:levels,id',
            'venue_id'          => 'nullable|exists:venues,id',
            'category_id'       => 'required|exists:category,id'
            // 'category_id.*'     => 'exists:categories,id',

            // 'sport'             => in:1,
            // 'type'              => 0,
            // 'level_id'          => 7,
            // 'venue_id'          => 'nullable',
            
        ]);

        // dd($validatedData);

        // if($request->file('image')){
        //     $validatedData['image']=$request->file('image')->store('post-image');
        // }

        $validatedData['user_id'] = auth()->user()->id;
        // $validatedData['excerpt'] = Str::limit(strip_tags($request->body), 200);

        $tournament = Tournament::create($validatedData);

        // Menyimpan championship
        Championship::create([
            'tournament_id' => $tournament->id,
            'category_id'   => $request->category_id,
        ]);


        return redirect('/dashboard/tours')->with('success', 'Turnamen Baru telah dibuat!');
        // return redirect('/dashboard/tours')->with('success', 'Post Baru telah dibuat!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('dashboard.tours.show',[
            'tour' => $tour
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Tournament $tour)
    {
        return view('dashboard.tours.edit', [
            'tours' => $tour,
            'categories' => Category::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tournament $tour)
    {
        $rules =[
            'name'              => 'required|max:255',
            'slug'              => 'required|unique:tournament',
            'dateIni'           => "required|date",
            'dateFin'           => "required|date|after_or_equal:dateIni",
            'registerDateLimit' => "nullable|date|before_or_equal:dateFin",
            'sport'             => 'nullable|in:1', 
            'type'              => 'nullable|in:0',
            'level_id'          => 'nullable|exists:levels,id',
            'venue_id'          => 'nullable|exists:venues,id',
            'category_id'       => 'required|exists:category,id'
        ];


        if($request->slug != $tour->slug){
            $rules['slug'] = 'required|unique:tournament';
        }

        $validatedData = $request->validate($rules);

        // if($request->file('image')){
        //     if($request->oldImage) {
        //         Storage::delete($request->oldImage);
        //     }
        //     $validatedData['image']=$request->file('image')->store('post-image');
        // }

        $validatedData['user_id'] = auth()->user()->id;

        // Ambil category_id lalu keluarkan dari data
        $categoryId = $validatedData['category_id'];
        unset($validatedData['category_id']);

        // Simpan ke tournaments (tanpa category_id)
        Tournament::where('id', $tour->id)->update($validatedData);

        // Simpan ke Championship
        Championship::where('tournament_id', $tour->id)->update([
            'category_id' => $categoryId,
        ]);



        return redirect('/dashboard/tours')->with('success', 'Turnamen telah diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tournament $tour)
    {
        // if($post->Image) {
        //     Storage::delete($post->Image);
        // }
        
        Tournament::destroy($tour->id);

        return redirect('/dashboard/tours')->with('success', 'Turnamen telah dihapus!');
    }
    
    public function checkSlug(Request $request){
        $slug = SlugService::createSlug(Tournament::class, 'slug', $request->title);
        return response()->json(['slug'=>$slug]);
    }
}
