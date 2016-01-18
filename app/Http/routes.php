<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['prefix' => '/admin','middleware' => 'web'],function(){
    
    Route::get('/',['uses' => 'TestController@dashboard']);
    
});

Route::get('/', function () {
    return view('welcome');
});


Route::get('/login', function () {
    return view('admin/login');
});

Route::post('/login',['uses' => 'TestController@login']);


Route::get('/register', function () {
    return view('admin/register');
});

