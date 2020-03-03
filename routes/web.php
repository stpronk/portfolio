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

Auth::routes(['register' => false]);

Route::group([
    'middleware' => ['auth'],
    'prefix' => 'admin'
], function () {
    Route::get('/', 'HomeController@index')->name('home');

    Route::group([
       'middleware' => ['isAdmin']
    ], function () {
        Route::get('/users', 'UserController@index')->name('user.index');
    });
});

/**
 * ROUTES THAT SHOULD SHOW THE WEB IT SELF SHOULD BE UNDER THIS LINE
 *
 * AUTH ROUTES SHOULD BE ABOVE
 */

Route::get('/', function () {
    return view('welcome');
});