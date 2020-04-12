<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PlaygroundController extends Controller
{
    public function wysiwyg() {
        return view('playground.wysiwyg');
    }
}
