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
    public $categories = [];
    public $values = [];

    public $selected;
    public $new;
    public $update;
    public $keep;

    protected $listeners = [
        'updatedCategory' => 'reloadVariables',
        'deletedCategory' => 'reloadVariables'
    ];

    public $rules = [
        'name'                => 'required|string|max:255',
        'type'                => 'required|string',
        'amount'              => 'required|numeric',
        'date'                => 'required|date',
        'notes'               => 'string|max:255|nullable',
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
        $this->expenses = array_values($group->Expenses->load('Category')->sortByDesc('date')->toArray());
        $this->categories = $group->Categories->toArray();
        $this->values = [
            'finance_group_id' => $group->id,
            'type' => Expense::$TYPES[0]
        ];

        $this->new = false;
        $this->update = false;

        $this->selected = '';
    }

    public function toggleCreate()
    {
        if( $this->new ) {
            return $this->reloadVariables();
        }

        return $this->new = !$this->new;
    }

    /**
     * Create an Expense
     *
     * @param array $values
     *
     * @return mixed
     */
    public function create()
    {
        $values = Validator::validate($this->values, $this->rules);

        $expense = new Expense($values);
        $expense->save();

        $this->emit('createdExpense');

        $this->reloadVariables();

        if( $this->keep ) {
            return $this->new = true;
        }
        return $this->new = false;
    }

    /**
     * Prepare update
     *
     * @param int $id
     *
     * @return array
     */
    public function prepareUpdate(int $id)
    {
        $this->reloadVariables();

        $this->update = true;
        $this->selected = $id;
        $expense = Expense::find($id);

        $this->values = [
            'date'                => $expense->rawData['date'],
            'name'                => $expense->name,
            'amount'              => $expense->rawData['amount'],
            'type'                => $expense->type,
            'notes'               => $expense->notes,
            'finance_category_id' => $expense->finance_category_id,
            'finance_group_id'    => $expense->finance_group_id,
        ];

        return $this->values;
    }


    /**
     * Update a Expense
     *
     * @param array                       $values
     * @param \App\Models\Finance\Expense $expense
     *
     * @return mixed
     */
    public function update()
    {
        $values = Validator::validate($this->values, $this->rules);
        $expense = Expense::find($this->selected);

        $expense->update($values);

        $this->emit('updatedExpense');

        return $this->reloadVariables();
    }

    public function cancelUpdate()
    {
        return $this->reloadVariables();
    }

    /**
     * Delete an Expense
     *
     * @param \App\Models\Finance\Expense $expense
     *
     * @return mixed
     * @throws \Exception
     */
    public function delete(Expense $expense) {
        $expense->delete();

        $this->emit('deletedExpense');

        return $this->reloadVariables();
    }

    /**
     * Reload the Expenses
     *
     * @return mixed
     */
    public function reloadVariables ()
    {
        $this->expenses = array_values($this->group->load('Expenses')->Expenses->sortByDesc('date')->toArray());
        $this->categories = $this->group->load('Categories')->Categories->toArray();

        $this->selected = '';
        $this->values = [
            'finance_group_id' => $this->group->id,
            'type' => Expense::$TYPES[0]
        ];

        $this->new = false;
        $this->update = false;

        return null;
    }

    /**
     * Render the component
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('livewire.finance.expenses', [
            'expenses' => $this->expenses,
            'categories' => $this->categories,

            'selectedExpense' => $this->selected !== '' ? Expense::findOrFail($this->selected)->toArray() : null,
        ]);
    }
}
