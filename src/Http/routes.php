<?php

use Illuminate\Support\Facades\Route;


Route::get('/', 'StarsenderCotroller@index');
Route::get('/list', 'StarsenderCotroller@list');
