<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Http\Requests\Finance\GroupCreateRequest;
use App\Models\Finance\Group;

class FinanceController extends Controller
{

    /**
     * Show the overview off all Finance groups that are available
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index ()
    {
        return view('finance.index');
    }

    /**
     * Show a specific finance group
     *
     * @param \App\Models\Finance\Group $group
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function group (Group $group)
    {
        return view('finance.group', [
            'group' => $group
        ]);
    }

    public function store (GroupCreateRequest $request)
    {
        $group = $request->save();

        return redirect()->route('finance.group', ['group' => $group->id]);
    }
}
