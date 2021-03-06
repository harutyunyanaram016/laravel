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
Route::get('logout', 'UserController@logout');
Route::post('login', 'UserController@postLogin');
Route::get('get-timer', 'UserController@getTime');
Route::get('admin', 'AdminController@index');
Route::get('admin/users', 'AdminController@getUsers');
Route::post('admin/remove-user', 'AdminController@deletUser');
Route::post('admin/add-project', 'AdminController@addProject');
Route::post('admin/project-user', 'AdminController@projectUser');
Route::post('admin/project-remove', 'AdminController@removeProject');
Route::post('admin/project-edit', 'AdminController@editProject');
Route::post('get-timer', 'UserController@postTimer');
Route::get('admin/create-user', 'AdminController@createUser');
Route::post('admin/create', 'AdminController@addUser');

