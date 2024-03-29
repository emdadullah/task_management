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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/tree/{userId?}', 'TaskController@tree')->name('tree_view');

Route::resource('tasks', 'TaskController');



Route::get('/users', 'UserController@index');
