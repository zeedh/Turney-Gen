<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', 'App\Http\Controllers\TreeController@index')->name('tree.index');
Route::post('/championships/{championship}/trees', 'App\Http\Controllers\TreeController@store')->name('tree.store');
Route::put('/championships/{championship}/trees', 'App\Http\Controllers\TreeController@update')->name('tree.update');
