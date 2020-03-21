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

    Route::post('login', 'Api\AuthController@login');

    Route::post('register', 'Api\AuthController@register');

    Route::group(['middleware' => 'auth:api'], function(){
        Route::post('getUser', 'Api\AuthController@getUser');
    });

});

Route::middleware('auth:api')->group(function () {

    Route::prefix('pet')->group(function () {

        Route::post('', 'Api\PetController@create');

        Route::put('', 'Api\PetController@update');

        Route::get('findByTags', 'Api\PetController@findByTags');

        Route::get('{petId}', 'Api\PetController@findById');

        Route::post('{petId}', 'Api\PetController@updateByForm');

        Route::delete('{petId}', 'Api\PetController@remove');

        Route::post('{petId}/uploadImage', 'Api\PetController@uploadImage');

    });

    Route::prefix('store')->group(function () {
        Route::prefix('order')->group(function () {

            Route::post('', 'Api\OrderController@create');

            Route::get('{orderId}','Api\OrderController@findById');

            Route::delete('{orderId}','Api\OrderController@remove');

        });
    });
});
