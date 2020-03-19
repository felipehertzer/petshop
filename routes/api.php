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

Route::middleware('auth:api')->group(function () {
    Route::prefix('pet')->group(function () {

        Route::post('', 'PetController@');

        Route::put('', 'PetController@');

        Route::get('', 'PetController@');

        Route::get('/pet/findByTags', 'PetController@');

        Route::post('{petId}', 'PetController@');

    });

    Route::prefix('store')->group(function () {
        Route::prefix('order')->group(function () {

            Route::post('', 'OrderController@create');

            Route::get('{orderId}','OrderController@findById');

            Route::delete('{orderId}','OrderController@remove');

        });
    });
});
