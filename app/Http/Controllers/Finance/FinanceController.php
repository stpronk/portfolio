<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Http\Requests\Finance\GroupCreateRequest;
use App\Models\Finance\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FinanceController extends Controller
{

    /**
     * Show the overview off all Finance groups that are available
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index ()
    {
        return view('finance.index', [
            'groups' => Auth::user()->FinanceGroups
        ]);
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

    public function createGroup (GroupCreateRequest $request)
    {
        $group = $request->save();

        return redirect()->route('finance.group', ['group' => $group->id]);
    }

    public function deleteGroup (Request $request)
    {
        $group = Group::find($request->get('group_id'));

        if($group->owner_id !== Auth::id() || !Auth::user()->is_admin) {
            throw new \Exception('You are not allowed to delete this group!', 403);
        }

        $group->delete();

        return redirect()->route('finance.index');
    }
}
