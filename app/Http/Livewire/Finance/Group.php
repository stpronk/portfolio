<?php

namespace App\Http\Livewire\Finance;

use Livewire\Component;
use \App\Models\Finance\Group as GroupModel;

class Group extends Component
{
    public $group;

    public function mount(GroupModel $group)
    {
        $this->group = $group;
    }

    public function render()
    {
        return view('livewire.finance.group', [
            'group' => $this->group
        ]);
    }
}
