<?php

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TreeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\AdminCategoryController;
use App\Http\Controllers\ChampionshipController;
use App\Http\Controllers\ChampCompetitorController;
use App\Http\Controllers\ChampSettingController;
use App\Http\Controllers\ChampTreeController;
use App\Http\Controllers\DashboardTurneyController;
use App\Http\Controllers\DashboardPostController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BaganController;
use App\Http\Controllers\TutorialController;
use App\Http\Controllers\Administrator;

use App\Http\Middleware\IsPanitia;
use Xoco70\LaravelTournaments\Models\Category;

Route::get('/', function () {
    return view('home', [
        "title" => "Home",
        'active' => 'home'
    ]);
});

Route::get('/blog', [PostController::class, 'index']);
Route::get('blog/{post:slug}', [PostController::class, 'show'])->name('blog.show');
Route::post('blog/{post:slug}', [PostController::class, 'store'])->name('blog.store');
Route::delete('blog/{post:slug}', [PostController::class, 'destroy'])->name('blog.destroy');

/*Route::get('/categories/{category:slug}', function(Category $category) {
    return view('blog', [
        'title' => "Post By Category : $category->name",
        'active' => 'categories',
        'posts' => $category->posts->load('category', 'author'),
    ]);
});

Route::get('/authors/{author:username}', function(User $author){
    return view('blog', [
        'title' => "Post By Author : $author->name",
        'posts' => $author->posts->load('category', 'author'),
    ]);
});*/

// Bagan di post
Route::get('bagan/{champ}', [BaganController::class, 'index'])->name('bagan.index');

Route::get('/about', function () {
    return view('about', [
        "title" => "About",
        "name" => "Zidan Dh",
        'active' => 'about',
        "email" => "zidan@gmail.com",
    ]);
});

Route::get('/categories', function() {
    return view('categories', [
        'title' => 'Post Categories',
        'active' => 'categories',
        'categories' => Category::all()
    ]);
});

Route::get('/tutorial', [TutorialController::class, 'index']);

// Login/Logout
Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout']);

// Register
Route::get('/register', [RegisterController::class, 'index'])->middleware('guest');

// Register Panitia
Route::get('/register/panitia', [RegisterController::class, 'Panitia'])->middleware('guest');
Route::post('/register/panitia', [RegisterController::class, 'storePanitia'])->middleware('guest');

// Register Peserta
Route::get('/register/peserta', [RegisterController::class, 'Peserta'])->middleware('guest');
Route::post('/register/peserta', [RegisterController::class, 'storePeserta'])->middleware('guest');

// Profile Peserta
Route::get('/profile', [ProfileController::class, 'pesertaIndex'])->name('profile.index')->middleware('auth');
Route::get('/profile/edit', [ProfileController::class, 'pesertaEdit'])->name('profile.edit')->middleware('auth');
Route::put('/profile/update', [ProfileController::class, 'pesertaUpdate'])->name('profile.update')->middleware('auth');

// Akses Foto Profil
Route::get('/profile-image/{filename}', function ($filename) {
    $path = storage_path('app/private/profile-images/' . $filename);

    if (!File::exists($path)) {
        abort(404);
    }

    return response()->file($path);
})->middleware('auth');

// Akses Foto Post
Route::get('/post-image/{filename}', function ($filename) {
    $path = storage_path('app/private/post-image/' . $filename);

    if (!File::exists($path)) {
        abort(404);
    }

    return response()->file($path);
})->name('post.image');

// ----------------------------
// Dashboard Group
// ----------------------------
Route::get('/dashboard/admin', [Administrator::class, 'index'])->name('admin.index')->middleware(['auth', IsPanitia::class]);
Route::get('/dashboard/admin/{user}/edit', [Administrator::class, 'edit'])->name('admin.edit')->middleware(['auth', IsPanitia::class]);
Route::put('/dashboard/admin/{user}/update', [Administrator::class, 'update'])->name('admin.update')->middleware(['auth', IsPanitia::class]);

Route::middleware(['auth', IsPanitia::class])
    ->prefix('dashboard')
    ->name('dashboard.')
    ->group(function () {

        // Dashboard Home
        Route::view('/', 'dashboard.index')->name('home');

        // Profile
        Route::get('profile', [ProfileController::class, 'panitiaIndex'])->name('profile.index');
        Route::get('profile/edit', [ProfileController::class, 'panitiaEdit'])->name('profile.edit');
        Route::put('profile/update', [ProfileController::class, 'panitiaUpdate'])->name('profile.update');

        // Turnamen
        Route::get('tours/checkSlug', [DashboardTurneyController::class, 'checkSlug'])->name('tours.checkSlug');
        Route::resource('tours', DashboardTurneyController::class);

        // Postingan
        Route::get('posts/checkSlug', [DashboardPostController::class, 'checkSlug'])->name('posts.checkSlug');
        Route::resource('posts', DashboardPostController::class);

        // Championship / Bagan
        Route::resource('champs', ChampionshipController::class);
        Route::resource('champs/{champ}/setting', ChampSettingController::class);

        // Competitors routes
        Route::prefix('champs/{champ}/competitors')
            ->name('competitors.')
            ->group(function () {
                Route::get('/', [ChampCompetitorController::class, 'index'])->name('index');
                Route::post('/', [ChampCompetitorController::class, 'store'])->name('store');
                Route::delete('/{competitor}', [ChampCompetitorController::class, 'destroy'])->name('destroy');

                Route::get('/seed', [ChampCompetitorController::class, 'editSeed'])->name('seed.edit');
                Route::post('/seed', [ChampCompetitorController::class, 'saveSeed'])->name('seed.save');
            });

        });
Route::resource('/dashboard/champs/{champ}/setting/{setting}', ChampSettingController::class);

