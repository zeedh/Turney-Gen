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
use Xoco70\LaravelTournaments\Models\Category;

Route::get('/', function () {
    return view('home', [
        "title" => "Home",
        'active' => 'home'
    ]);
});

Route::get('/blog', [PostController::class, 'index']);
Route::get('blog/{post:slug}', [PostController::class, 'show']);

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

// Login/Logout
Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout']);

// Register
Route::get('/register', [RegisterController::class, 'index'])->middleware('guest');
Route::post('/register', [RegisterController::class, 'store']);

// Dashboard
Route::get('dashboard',function(){return view('dashboard.index');})->middleware('auth');

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