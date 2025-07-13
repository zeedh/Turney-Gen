<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tournament;
use Xoco70\LaravelTournaments\Models\Championship;
use Xoco70\LaravelTournaments\Models\Competitor;
use Illuminate\Http\Request;
use \Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
 

class DashboardPostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
public function index()
{
    $tours = Tournament::where('user_id', auth()->id())->get();

    $championships = Championship::whereIn('tournament_id', $tours->pluck('id'))
        ->with('category')
        ->get()
        ->groupBy('tournament_id');

    return view('dashboard.posts.index', [
        'posts' => Post::where('user_id', auth()->id())->with('tournament')->get(),
        'tours' => $tours,
        'champs' => $championships
    ]);
}



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tours = Tournament::where('user_id', auth()->user()->id)->get();
        return view('dashboard.posts.create', [
            'categories'   => Category::all(),
            'tours'        => $tours
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
public function store(Request $request)
{
    $validatedData = $request->validate([
        'title'         => 'required|max:255',
        'slug'          => 'required|unique:posts',
        'tournament_id' => 'required|exists:tournament,id', // pastikan turnamen valid
        'image'         => 'image|file|max:1024',
        'body'          => 'required'
    ]);

    // Ambil category_id dari championship yang terkait tournament_id
    $championship = Championship::where('tournament_id', $request->tournament_id)->first();

    if (!$championship) {
        return back()->withErrors(['tournament_id' => 'Turnamen belum memiliki championship'])->withInput();
    }

    $validatedData['category_id'] = $championship->category_id;

    if ($request->file('image')) {
        $validatedData['image'] = $request->file('image')->store('post-image');
    }

    $validatedData['user_id'] = auth()->id();
    $validatedData['excerpt'] = Str::limit(strip_tags($request->body), 200);

    Post::create($validatedData);

    return redirect('/dashboard/posts')->with('success', 'Post Baru telah dibuat!');
}

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        $user = Auth::user();
        $competitorIds = [];
        if ($user) {
            $competitorIds = Competitor::where('user_id', $user->id)
                ->pluck('championship_id')
                ->toArray();
        }

        $tour = Tournament::where('id', $post->tournament_id)->first();

        $champs = Championship::where('tournament_id', $post->tournament_id)->get();
        // $champs = $post->tournament->championships;

        return view('dashboard.posts.show', [
            'competitorChampionshipIds' => $competitorIds,
            'post'   => $post,
            'champs' => $champs,
            'tour'  => $tour
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return view('dashboard.posts.edit', [
            'post' => $post,
            'categories' => Category::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $rules =[
            'title' => 'required|max:255',
            'category_id' => 'required',
            'tournament_id' => 'required',
            'image' => 'image|file|max:1024',
            'body' => 'required'
        ];


        if($request->slug != $post->slug){
            $rules['slug'] = 'required|unique:posts';
        }

        $validatedData = $request->validate($rules);

        if($request->file('image')){
            if($request->oldImage) {
                Storage::delete($request->oldImage);
            }
            $validatedData['image']=$request->file('image')->store('post-image');
        }

        $validatedData['user_id'] = auth()->user()->id;
        $validatedData['excerpt'] = Str::limit(strip_tags($request->body), 200);

        Post::where('id', $post->id)
        ->update($validatedData);

        return redirect('/dashboard/posts')->with('success', 'Post Baru telah diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        if($post->Image) {
            Storage::delete($post->Image);
        }
        
        Post::destroy($post->id);

        return redirect('/dashboard/posts')->with('success', 'Post telah dihapus!');
    }
    
    public function checkSlug(Request $request){
        $slug = SlugService::createSlug(Post::class, 'slug', $request->title);
        return response()->json(['slug'=>$slug]);

    }
}
