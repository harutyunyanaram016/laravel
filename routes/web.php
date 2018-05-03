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

Route::get('/', 'UserController@index');
Route::get('login', 'UserController@getLogin');
Route::get('get-timer', 'UserController@getTime');
Route::get('admin', 'AdminController@index');
Route::post('admin/remove-user', 'AdminController@deletUser');
Route::post('get-timer', 'UserController@postTimer');
Route::get('admin/create-user', 'AdminController@createUser');
