<?php

use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/', 'halamanController@homepage')->name('homepage');
// Route::get('/home', 'HomeController@index')->name('home');
Route::get('{path}', 'halamanController')->where('path', '(.*)');