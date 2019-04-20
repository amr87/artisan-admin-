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

Route::get('/facebook', [ 'uses' => 'UsersController@redirectToProvider', 'middleware' => 'web']);
Route::get('/facebook/callback', [ 'uses' => 'UsersController@handleProviderCallback', 'middleware' => 'web']);


/*
 * 
 *  Basic Action
 */

Route::get('/login', ['uses' => 'UsersController@login', 'middleware' => 'web']);

Route::get('/logout', ['uses' => 'UsersController@logout', 'middleware' => 'web']);

Route::post('/login', ['uses' => 'UsersController@processLogin', 'middleware' => 'web']);

Route::get('/forget-password', ['uses' => 'UsersController@forgetPassword']);

Route::get('/get-conversation', ['uses' => 'UsersController@getConversation', 'middleware' => 'web']);

Route::post('/post-message', ['uses' => 'UsersController@postMessage', 'middleware' => 'web']);

Route::post('/message-seen', ['uses' => 'UsersController@seenMessage', 'middleware' => 'web']);

Route::post('/reset-password', ['uses' => 'UsersController@processForgetPassword', 'middleware' => 'web']);

Route::get('/reset-password', ['uses' => 'UsersController@resetPassword', 'middleware' => 'web']);

Route::get('/user-conversations', ['uses' => 'UsersController@userConversation', 'middleware' => 'web']);


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

    Route::post('/users/flushSession', ['uses' => 'UsersController@flushSession']);
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
     * Permissions Route
     */
    Route::get('/permissions/dataTables', ['uses' => 'PermissionsController@dataTables']);
    Route::get('/permissions/{id}/delete', ['uses' => 'PermissionsController@destroy']);
    Route::resource('permissions', 'PermissionsController');


    /*
     * Countries Route
     */
    Route::get('/country/states/{id}', ['uses' => 'CountriesController@getStates']);
    Route::get('/country/states/{id}/dataTables', ['uses' => 'CountriesController@getStatesDataTable']);
    Route::get('/countries/dataTables', ['uses' => 'CountriesController@dataTables']);
    Route::get('/countries/{id}/delete', ['uses' => 'CountriesController@destroy']);
    Route::resource('countries', 'CountriesController');



    /*
     * States Route
     */

    Route::get('/states/districts/{id}', ['uses' => 'DistrictsController@getDistricts']);
    Route::get('/states/districts/{id}/dataTables', ['uses' => 'DistrictsController@getDistrictsDataTable']);
    Route::get('/states/dataTables', ['uses' => 'StatesController@dataTables']);
    Route::get('/states/{id}/delete', ['uses' => 'StatesController@destroy']);


    Route::resource('states', 'StatesController');
    Route::get('/states/{id}/create', ['uses' => 'StatesController@create']);


    /*
     * Districts Route
     */
    Route::get('/districts/dataTables', ['uses' => 'DistrictsController@dataTables']);
    Route::get('/districts/create/{id}', ['uses' => 'DistrictsController@create']);
    Route::get('/districts/{id}/delete', ['uses' => 'DistrictsController@destroy']);
    Route::resource('districts', 'DistrictsController');
    Route::get('/districts/{id}/create', ['uses' => 'DistrictsController@create']);


    /*
     * Compamnies Route
     */
    Route::get('/companies/dataTables', ['uses' => 'CompaniesController@dataTables']);
    Route::get('/companies/{id}/delete', ['uses' => 'CompaniesController@destroy']);
    Route::resource('companies', 'CompaniesController');
    /*
     * Categories Route
     */
    Route::get('/categories/dataTables', ['uses' => 'CategoriesController@dataTables']);
    Route::get('/categories/{id}/delete', ['uses' => 'CategoriesController@destroy']);
    Route::resource('categories', 'CategoriesController');
});
