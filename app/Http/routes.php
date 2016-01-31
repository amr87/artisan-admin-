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

Route::get('/login', ['uses' => 'UsersController@login', 'middleware' => 'web']);

Route::get('/logout', ['uses' => 'UsersController@logout', 'middleware' => 'web']);

Route::post('/login', ['uses' => 'UsersController@processLogin', 'middleware' => 'web']);


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

    /*
     * Users Route
     */
    Route::post('/users/upload/{id}', ['uses' => 'UsersController@uploadAvatar']);
    Route::get('/users/dataTables', ['uses' => 'UsersController@dataTables']);
    Route::get('/users/{id}/delete', ['uses' => 'UsersController@destroy']);
    Route::resource('users', 'UsersController');


    /*
     * Roles Route
     */
    Route::get('/roles/dataTables', ['uses' => 'RolesController@dataTables']);
    Route::get('/roles/{id}/delete', ['uses' => 'RolesController@destroy']);
    Route::resource('roles', 'RolesController');

    /*
     * Roles Route
     */
    Route::get('/permissions/dataTables', ['uses' => 'PermissionsController@dataTables']);
    Route::get('/permissions/{id}/delete', ['uses' => 'PermissionsController@destroy']);
    Route::resource('permissions', 'PermissionsController');
});
