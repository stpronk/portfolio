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
Route::get('/dashboard', 'HomeController@index')->name('home');

/**
 * ASSIGNMENTS ROUTES
 */
Route::group([
    'prefix' => 'assignments',
], function () {
    Route::get('/', 'AssignmentController@index')->name('assignments');
    Route::get('/dealer', 'AssignmentController@dealer')->name('assignment.dealer');
    Route::get('/event-planner', 'AssignmentController@eventPlanner')->name('assignment.event-planner');
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
    Route::get('/{group}', 'FinanceController@group')->name('finance.group');

    Route::post('/group/create', 'FinanceController@createGroup')->name('finance.group.create');
    Route::delete('group/delete', 'FinanceController@deleteGroup')->name('finance.group.delete');
});

/**
 * ADMIN ROUTES
 */
Route::group([
    'middleware' => ['auth'],
    'prefix' => 'admin'
], function () {
    Route::get('/playground/wysiwyg', 'PlaygroundController@wysiwyg')->name('playground.wysiwyg');

    Route::group([
        'middleware' => ['isAdmin']
    ], function () {
        Route::get('/users', 'UserController@index')->name('users.index');
        Route::get('/site', 'SiteController@index')->name('site.index');
    });
});
