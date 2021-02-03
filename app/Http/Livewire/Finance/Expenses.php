<?php

namespace App\Http\Livewire\Finance;

use App\Models\Finance\Expense;
use App\Models\Finance\Group as GroupModel;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class Expenses extends Component
{
    public $group;

    public $expenses = [];

    public $rules = [
        'name'                => 'string|max:255',
        'type'                => 'integer',
        'amount'              => 'integer',
        'date'                => 'date',
        'notes'               => 'string|max:255',
        'finance_group_id'    => 'integer|exists:finance_group,id',
        'finance_category_id' => 'integer|exists:finance_category,id|nullable',
    ];

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
     * Create an Expense
     *
     * @param array $values
     *
     * @return mixed
     */
    public function create(array $values)
    {
        $values = Validator::validate($values, $this->rules);

        $expense = new Expense($values);
        $expense->save();

        $this->emit('createdExpense');

        return $this->reloadExpenses();
    }

    /**
     * Update a Expense
     *
     * @param array                       $values
     * @param \App\Models\Finance\Expense $expense
     *
     * @return mixed
     */
    public function update(array $values, Expense $expense)
    {
        $values = Validator::validate($values, $this->rules);

        $expense->update($values);

        $this->emit('updatedExpense');

        return $this->reloadExpenses();
    }

    /**
     * Reload the Expenses
     *
     * @return mixed
     */
    private function reloadExpenses ()
    {
        return $this->expenses = $this->group->load('Expenses')->Expenses->toArray();
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
