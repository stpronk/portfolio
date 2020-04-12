<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index () {
        return view('users.index');
    }

    public function update( User $user ) {
        $user->email;
        // Rest of code
    }
}
