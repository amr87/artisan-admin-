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

Route::group(['prefix' => '/admin', 'middleware' => 'web'], function() {

    Route::get('/', ['uses' => 'DashboardController@index']);
    Route::resource('users','UsersController');
});


Route::get('/guzzle', function () {
    
   
//    for($i = 0 ; $i < 300 ; $i++){
// 
//     $params = ['username' => "test".$i , "email" => 'test'.$i.'@test.com' , 'password' => str_random(8) ,'display_name' => 'Test User '.$i];
//    $request = API::post("users/register", [], $params);
//
//
//    }
});