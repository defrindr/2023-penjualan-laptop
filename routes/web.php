<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/classification', 'ClassificationController@index')->name('classification.view');
Route::post('/classification/analyst', 'ClassificationController@analyst')->name('classification.analyst');

Route::get('/filter', 'ClassificationController@filter')->name('filter.view');
Route::post('/filter/analyst', 'ClassificationController@filterAnalyst')->name('filter.analyst');

Auth::routes(['register' => false, 'reset' => false, 'confirm' => false]);

Route::name('admin.')->group(function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/profile', 'ProfileController@index')->name('profile');
    Route::put('/profile', 'ProfileController@update')->name('profile.update');

    // data master
    Route::get('/tool/up', 'ToolController@up')->name('tool.up');
    Route::name('master.')->group(function () {
        Route::resource('laptop', 'LaptopController');
    });
});
