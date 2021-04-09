<?php

namespace App\Http\Livewire\Finance;

use App\Models\Finance\Expense;
use App\Models\Finance\Group as GroupModel;
use Carbon\Carbon;
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
    public $delete;
    public $keep;
    public $search = '';

    protected $listeners = [
        'createdCategory' => 'reloadVariables',
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

    public $queryString = [
        'search'
    ];

    /**
     * Mount the component
     *
     * @param \App\Models\Finance\Group $group
     */
    public function mount(GroupModel $group)
    {
        $this->group = $group;
        $this->reloadVariables();

        $this->selected = '';
    }

    public function toggleCreate()
    {
        // Reset values when cancels
        if( $this->new ) {
            return $this->reloadVariables();
        }

        // Set selected on null
        if ($this->selected !== '') {
            $this->selected = '';
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
            $this->values['date'] = $values['date'];
            $this->values['finance_category_id'] = $values['finance_category_id'];

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

        $this->fillValues($id);

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

    /**
     * Cancel the update of an expense
     */
    public function cancelUpdate()
    {
        return $this->reloadVariables();
    }

    /**
     * Prepare Delete
     */
    public function prepareDelete(int $id) {
        $this->reloadVariables();

        $this->delete = true;
        $this->selected = $id;

        $this->fillValues($id);

        return $this->values;
    }

    /**
     * Delete an Expense
     *
     * @param \App\Models\Finance\Expense $expense
     *
     * @return mixed
     * @throws \Exception
     */
    public function delete() {
        $expense = Expense::find($this->selected);
        $expense->delete();

        $this->emit('deletedExpense');

        return $this->reloadVariables();
    }

    /**
     * Cancel the delete
     */
    public function cancelDelete ()
    {
        $this->reloadVariables();
    }

    /**
     * Reload the Expenses
     *
     * @return mixed
     */
    public function reloadVariables ()
    {
        $this->expenses = $this->loadExpenses();
        $this->categories = $this->group->load('Categories')->Categories->toArray();

        $this->selected = '';
        $this->values = [
            'date' => Carbon::now()->format('Y-m-d'),
            'finance_group_id' => $this->group->id,
            'type' => Expense::$TYPES[0]
        ];

        $this->new = false;
        $this->update = false;
        $this->delete = false;

        return null;
    }

    /**
     * Fill values as an helper function
     *
     * @param int $expenseId
     *
     * @return array
     */
    protected function fillValues(int $expenseId) {
        $expense = Expense::find($expenseId);

        return $this->values = [
            'date'                => $expense->rawData['date'],
            'name'                => $expense->name,
            'amount'              => $expense->rawData['amount'],
            'type'                => $expense->type,
            'notes'               => $expense->notes,
            'finance_category_id' => $expense->finance_category_id,
            'finance_group_id'    => $expense->finance_group_id,
        ];
    }

    /**
     * Load the expenses
     *
     * @return mixed
     */
    protected function loadExpenses ()
    {
        $search = $this->search;

        return $this->expenses = $this->group
            // Load the correct Expenses from the group
            ->load(['Expenses' => function ($q) use ($search) {
                $q->leftJoin('finance_category', 'finance_expense.finance_category_id', '=', 'finance_category.id')
                    ->where('finance_expense.name', 'like', "%{$search}%")
                    ->orWhere('finance_expense.notes', 'like', "%{$search}%")
                    ->orWhere('finance_category.name', 'like', "%{$search}%")
                    ->select('finance_expense.*');
            }])

            // Go further with the Expenses & load the categories
            ->Expenses
            ->load('Category')

            // Sort and group the expenses by date
            ->sortByDesc('date')
            ->groupBy(function ($expense) {
                return Carbon::parse($expense->date)->format('Y-m');
            })->toArray();
    }

    /**
     * Render the component
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('livewire.finance.expenses', [
            'expenses' => $this->loadExpenses(),
            'categories' => $this->categories,

            'selectedExpense' => $this->selected !== '' ? Expense::findOrFail($this->selected)->toArray() : null,
        ]);
    }
}
