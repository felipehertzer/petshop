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

Route::prefix('auth')->group(function(){

    Route::post('login', 'ApiAuthController@login');

    Route::post('register', 'ApiAuthController@register');

    Route::group(['middleware' => 'auth:api'], function(){
        Route::post('getUser', 'ApiAuthController@getUser');
    });

});

Route::middleware('auth:api')->group(function () {

    Route::prefix('pet')->group(function () {

        Route::post('', 'PetController@create');

        Route::put('', 'PetController@update');

        Route::get('findByTags', 'PetController@findByTags');

        Route::get('{petId}', 'PetController@findById')->where('petId', '[0-9]+');

        Route::post('{petId}', 'PetController@updateByForm')->where('petId', '[0-9]+');

        Route::delete('{petId}', 'PetController@remove')->where('petId', '[0-9]+');

        Route::post('{petId}/uploadImage', 'PetController@uploadImage')->where('petId', '[0-9]+');

    });

    Route::prefix('store')->group(function () {
        Route::prefix('order')->group(function () {

            Route::post('', 'OrderController@create');

            Route::get('{orderId}','OrderController@findById')->where('orderId', '[0-9]+');

            Route::delete('{orderId}','OrderController@remove')->where('orderId', '[0-9]+');

        });
    });
});
