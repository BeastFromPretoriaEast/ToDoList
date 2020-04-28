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
    return view('auth.login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' => 'api/v1'], function() {
    Route::get('todos/active', 'TodoController@getAllActiveTodos');
    Route::get('todos/completed', 'TodoController@getAllCompletedTodos');
    Route::get('todos/getTodo/{id}', 'TodoController@getTodo');
    Route::post('todos/changeDoneState/{id}', 'TodoController@changeDoneState');
    Route::resource('todos', 'TodoController');

    Route::get('user/getProfile', 'UserController@getProfile');
    Route::post('user/updateProfile', 'UserController@updateProfile');
});
