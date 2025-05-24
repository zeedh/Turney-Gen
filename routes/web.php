<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TreeController;
use App\Http\Controllers\AdminCategoryController;
use Xoco70\LaravelTournaments\Models\Category;

Route::get('/', function () {
    return view('home', [
        "title" => "Home",
        'active' => 'home'
    ]);
});

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


// Route::get('/', 'App\Http\Controllers\TreeController@index')->name('tree.index');
// Route::post('/championships/{championship}/trees', 'App\Http\Controllers\TreeController@store')->name('tree.store');
// Route::put('/championships/{championship}/trees', 'App\Http\Controllers\TreeController@update')->name('tree.update');
