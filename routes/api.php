<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


// Auth::routes();
Route::post('daftar','API\autentikasiController@registrasiAutentikasi');

Route::middleware('auth:api')->group(function(){
	
});
