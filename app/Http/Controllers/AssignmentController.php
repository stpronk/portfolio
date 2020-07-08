<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AssignmentController extends Controller
{
    public function dealer ()
    {
//        include "https://travalli.nl/administrator/includes/inidb.php";
//
//        dd(var_dump());

        return view('assignments.dealer');
    }
}
