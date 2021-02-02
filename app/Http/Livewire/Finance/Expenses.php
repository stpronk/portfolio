<?php

namespace App\Http\Livewire\Finance;

use App\Models\Finance\Group as GroupModel;
use Livewire\Component;

class Expenses extends Component
{
    public $group;

    public $expenses = [];

    /**
     * Mount the component
     *
     * @param \App\Models\Finance\Group $group
     */
    public function mount(GroupModel $group)
    {
        $this->group = $group;
        $this->expenses = $group->Expenses->toArray();
    }

    /**
     * Render the component
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('livewire.finance.expenses', [
            'expenses' => $this->expenses
        ]);
    }
}
