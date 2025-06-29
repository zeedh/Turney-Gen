<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Category;
use Xoco70\LaravelTournaments\Models\Championship;
use Xoco70\LaravelTournaments\Models\Competitor;

class PostController extends Controller
{
    public function index() {

        $title='';
        if(request('category')) {
            $category = Category::firstWhere('slug', request('category'));
            $title= ' in ' . $category->name;
        }

        if(request('author')) {
            $author = User::firstWhere('username', request('author'));
            $title= ' by ' . $author->name;
        }

        return view('blog', [
            "title" => "Post Turnamen" . $title,
            "active" => 'blog',
            //"posts" => Post::all()
            "posts" => Post::latest()->filter(request(['search', 'category', 'author']))->paginate(7)->withQueryString()
        ]);
    }

    public function show(Post $post) {

        $user = Auth::user();

        $competitorIds = [];
        if ($user) {
            $competitorIds = Competitor::where('user_id', $user->id)
                ->pluck('championship_id')
                ->toArray();
        }

        $champs = Championship::where('tournament_id', $post->tournament_id)->get();
        return view('post', [
            "title" => "Single Post",
            "post" => $post,
            "active" => 'blog',
            'champs' => $champs,
            'competitorChampionshipIds' => $competitorIds,
            'user' => $user,
        ]);
    }

    public function store(Request $request, Championship $champ)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'championship_id' => 'required|exists:championship,id',
        ]);

        if ($champ->id != $validated['championship_id']) {
            abort(403, 'Invalid championship data.');
        }

        $exists = Competitor::where('championship_id', $champ->id)
                    ->where('user_id', $validated['user_id'])
                    ->exists();

        if ($exists) {
            return back()->with('error', 'User sudah terdaftar sebagai peserta.');
        }

        $shortId = random_int(1, 200);
        while (Competitor::where('short_id', $shortId)->exists()) {
            $shortId = random_int(1, 200);
        }

        Competitor::create([
            'user_id' => $validated['user_id'],
            'championship_id' => $champ->id,
            'confirmed' => false,
            'short_id' => $shortId,
        ]);

        return redirect()
            ->route('champs.competitors.index', $champ->id)
            ->with('success', 'Peserta berhasil ditambahkan!');
    }

    public function destroy(Request $request, Championship $champ)
    {
        $userId = auth()->id();

        $competitor = Competitor::where('championship_id', $champ->id)
            ->where('user_id', $userId)
            ->first();

        if ($competitor) {
            $competitor->delete();
            return back()->with('success', 'Pendaftaran berhasil dibatalkan.');
        }

        return back()->with('error', 'Data tidak ditemukan.');
    }


}
