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
    return redirect('/admin');
});

/*
 * Social Login
 *  
 */

Route::get('/facebook',[ 'uses'=> 'UsersController@redirectToProvider', 'middleware' => 'web']);
Route::get('/facebook/callback', [ 'uses'=>'UsersController@handleProviderCallback', 'middleware' => 'web']);


/*
 * 
 *  Basic Action
 */

Route::get('/login', ['uses' => 'UsersController@login', 'middleware' => 'web']);

Route::get('/logout', ['uses' => 'UsersController@logout', 'middleware' => 'web']);

Route::post('/login', ['uses' => 'UsersController@processLogin', 'middleware' => 'web']);

Route::get('/forget-password', ['uses' => 'UsersController@forgetPassword']);

Route::post('/reset-password', ['uses' => 'UsersController@processForgetPassword', 'middleware' => 'web']);

Route::get('/reset-password', ['uses' => 'UsersController@resetPassword', 'middleware' => 'web']);


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
    Route::get('/users/trashedDataTables', ['uses' => 'UsersController@trashedDataTables']);
    Route::get('/users/dataTables', ['uses' => 'UsersController@dataTables']);
    Route::get('/users/saveClient', ['uses' => 'UsersController@saveClient']);
    Route::get('/users/search', ['uses' => 'UsersController@search']);
    Route::post('/users/upload/{id}', ['uses' => 'UsersController@uploadAvatar']);
    Route::get('/users/trashed', ['uses' => 'UsersController@trashed']);
    Route::get('/users/{id}/delete', ['uses' => 'UsersController@destroy']);
    Route::get('/users/{id}/force-delete', ['uses' => 'UsersController@forceDelete']);
    Route::get('/users/{id}/restore', ['uses' => 'UsersController@restore']);
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
