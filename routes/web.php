<?php

use Illuminate\Support\Facades\Route;


Route::view('/', 'welcome')->name('homepage');

// ja bym osobiście te linijki wrzucił do pliku api.php
// pomija się wtedy csrf middleware, który dla tych routów niby też można wyłączyć ale niezalecane
// zostawiam tu bo podane endpointy w zadaniu mają być /movies...
Route::resource('movies', 'Api\\MovieController');
Route::get('movies/title/{title}', 'Api\\MovieController@findByTitle');
