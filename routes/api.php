<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Auth::routes();

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('daftar','API\autentikasiController@store');
Route::get('produk','API\produkController@index');


Route::middleware('auth:api')->group(function(){
    Route::post('/sso-login','API\ssoLoginController@login');
    
    Route::apiResources(['index-user' => 'API\userController'],[
    	'except'=>['edit','show','create']
    ]);

    Route::apiResources(['index-kategori' => 'API\kategoriController'],[
    	'except'=>['edit','show','create']
    ]);

    Route::apiResources(['index-produk' => 'API\produkController'],[
        'except'=>['edit','show','create']
    ]);

    Route::apiResources(['troli' => 'API\troliController'],[
        'only'=>['index','store','destroy','update']
    ]);

    Route::apiResources(['transaksi' => 'API\transaksiController'],[
        'only'=>['index','store','destroy','update','show']
    ]);
    Route::apiResources(['bio' => 'API\bioController'],[
        'only'=>['index','store','update','create']
    ]);
    Route::apiResources(['rajaonkir' => 'API\rajaOnkirController'],[
        'only'=>['index']
    ]);



});
