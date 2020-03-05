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


/**
 * ROUTES THAT ARE AUTH RELATED
 *
 * These router all have the admin prefix (Except for the auth routes)
 */
Auth::routes(['register' => false]);

Route::group([
    'middleware' => ['auth'],
    'prefix' => 'admin'
], function () {
    Route::get('/', 'HomeController@index')->name('home');

    Route::group([
        'middleware' => ['isAdmin']
    ], function () {
        Route::get('/users', 'UserController@index')->name('users.index');
    });
});
