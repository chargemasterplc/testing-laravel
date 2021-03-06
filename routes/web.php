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

Auth::routes();

Route::get('/', function() {
    return redirect('login');
});

Route::get('tasks', 'TaskController@index');
Route::post('tasks', 'TaskController@create');
Route::post('tasks/complete/{task}', 'TaskController@completeTask');
