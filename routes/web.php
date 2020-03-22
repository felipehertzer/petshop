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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/pets', 'Web\PetController@index');
Route::get('/orders', 'Web\OrderController@index');
Route::get('/categories', 'Web\CategoryController@index');
Route::get('/users', 'Web\UserController@index');
