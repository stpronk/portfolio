<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AssignmentController extends Controller
{
    public function dealer ()
    {
        return view('assignments.dealer');
    }

    public function eventPlanner () {
        return view('assignments.eventPlanner');
    }
}
