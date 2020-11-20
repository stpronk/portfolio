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

use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});


/**
 * ROUTES THAT ARE AUTH RELATED
 *
 * These router all have the admin prefix (Except for the auth routes)
 */
Auth::routes(['register' => false]);

/**
 * ASSIGNMENTS ROUTES
 */
Route::group([
    'prefix' => 'assignments',
], function () {
    Route::get('dealer', 'AssignmentController@dealer')->name('assignment.dealer');
});

/**
 * FINANCE ROUTES
 */
Route::group([
    'middleware' => ['auth'],
    'prefix' => 'finance',
    'namespace' => 'Finance'
], function () {
    Route::get('/', 'FinanceController@index')->name('finance.index');
    Route::post('/store', 'FinanceController@store')->name('finance.store');

    Route::get('/{group}', 'FinanceController@group')->name('finance.group');
    Route::post('/{group}/category/store', 'CategoryController@store')->name('finance.category.store');
});

/**
 * ADMIN ROUTES
 */
Route::group([
    'middleware' => ['auth'],
    'prefix' => 'admin'
], function () {
    Route::get('/', 'HomeController@index')->name('home');

    Route::get('/playground/wysiwyg', 'PlaygroundController@wysiwyg')->name('playground.wysiwyg');

    Route::group([
        'middleware' => ['isAdmin']
    ], function () {
        Route::get('/users', 'UserController@index')->name('users.index');
    });
});
