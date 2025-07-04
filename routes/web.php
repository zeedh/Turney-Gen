<?php

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

// Bagan di post
Route::get('bagan/{champs}', [BaganController::class, 'index'])->name('bagan.index');

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


//Profile
// Route::resource('/dashboard/profile', ProfileController::class)->middleware('auth');
Route::middleware(['auth'])->group(function () {
    Route::get('dashboard/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('dashboard/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('dashboard/profile/update', [ProfileController::class, 'update'])->name('profile.update');
});

// Dashboard
Route::get('dashboard',function(){return view('dashboard.index');})->middleware(IsPanitia::class);

// Turnamen
Route::get('dashboard/tours/checkSlug', [DashboardTurneyController::class, 'checkSlug'])->middleware('auth');
Route::resource('/dashboard/tours', DashboardTurneyController::class)->middleware('auth');

//POstingan
Route::get('dashboard/posts/checkSlug', [DashboardPostController::class, 'checkSlug'])->middleware('auth');
Route::resource('/dashboard/posts', DashboardPostController::class)->middleware('auth');

//Championship/Bagan
Route::resource('/dashboard/champs', ChampionshipController::class)->middleware('auth');
// Route::resource('/dashboard/champs/edit/{champ}/setting', ChampSettingController::class)->middleware('auth');
Route::resource('/dashboard/champs/{champ}/setting', ChampSettingController::class)->middleware('auth');

// Route::put('/dashboard/champs/{champ}/competitors', [ChampCompetitorController::class, 'update'])->name('competitors.seed')->middleware('auth');
Route::middleware('auth')->prefix('/dashboard/champs/{champ}/competitors')->name('competitors.')->group(function () {
    Route::get('/', [ChampCompetitorController::class, 'index'])->name('index');
    Route::post('/', [ChampCompetitorController::class, 'store'])->name('store');
    Route::delete('/{competitor}', [ChampCompetitorController::class, 'destroy'])->name('destroy');

    // Custom routes for seeding
    Route::get('/seed', [ChampCompetitorController::class, 'editSeed'])->name('seed.edit');
    Route::post('/seed', [ChampCompetitorController::class, 'saveSeed'])->name('seed.save');
});


Route::resource('/dashboard/champs/{champ}/setting/{setting}', ChampSettingController::class)->middleware('auth');