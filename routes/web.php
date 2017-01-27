<?php

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

Route::get('/', 'BachController@index');
Route::get('/fetch','BachController@fetch');
Route::get('/{id}', 'BachController@student');

// Auth::routes();

// Route::get('/home', 'HomeController@index');
