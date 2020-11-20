<?php

/*
|--------------------------------------------------------------------------
| Bindings
|--------------------------------------------------------------------------
| Here is white you can register bindings for your routes in your
| application. The bindings are loaded in the same way as the web routes
| are loaded. Any modification for this can be done in the
| RouteServiceProvider
|
*/

use Illuminate\Support\Facades\Auth;

/**
 * ALL THE FINANCE MODEL BINDINGS THAT ARE NEEDED WIHTIN THE APPLICATION
 */
Route::bind('group', function ($value) {
    if ( ! $group = \App\Models\Finance\Group::where('id', $value)->first()) {
        abort(404);
    };

    if ( ! ((Auth::user()->id == $group->owner_id) || Auth::user()->isAdmin())) {
        abort(302);
    };

    return $group;
});