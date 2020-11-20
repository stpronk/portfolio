<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Http\Requests\Finance\CategoryCreateRequest;

class CategoryController extends Controller
{
    public function store (CategoryCreateRequest $request)
    {
        $request->save();

        return response()->json($request->jsonResponse(), 200);
    }
}
