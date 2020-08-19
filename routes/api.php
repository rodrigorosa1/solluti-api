<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::get('/', function () {
    if (env("APP_ENV") == 'local') {
        $routes = collect(Route::getRoutes())->map(function ($route) {
            return $route->uri();
        });
        return $routes;
    }
    abort(401);
});


Route::group(['prefix' => 'store'], function () {
    Route::get('/', 'StoreController@index');
    Route::post('/store', 'StoreController@store');
    Route::get('/{id}', 'StoreController@show');
    Route::any('/update/{id}', 'StoreController@update');
    Route::any('/delete/{id}', 'StoreController@delete');
});

Route::group(['prefix' => 'product'], function () {
    Route::get('/', 'ProductController@index');
    Route::post('/save', 'ProductController@store');
    Route::get('/store/{id}', 'ProductController@productsStore');
    Route::get('/{id}', 'ProductController@show');
    Route::any('/update/{id}', 'ProductController@update');
    Route::any('/delete/{id}', 'ProductController@delete');
});
