<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::view('/', 'welcome')->name('homepage');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('movies', 'Api\\MovieController'); // ja bym osobiście tą linijke wrzucił do pliku api.php ale podane endpointy w zadaniu mają być /movies...
