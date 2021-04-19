<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function index()
    {
        return view('site.index');
    }

    public function portfolio ()
    {
        return view('site.portfolio');
    }

    public function analytics ()
    {
        return view('site.analytics');
    }
}
