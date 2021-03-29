<?php

namespace App\Http\Livewire\Finance;

use App\Models\Finance\Category;
use \App\Models\Finance\Group as GroupModel;
use \Illuminate\Support\Facades\Validator;
use Livewire\Component;

class Categories extends Component
{

    /**
     * @var
     */
    public $group;

    /**
     * @var array
     */
    public $categories;

    /**
     * @var mixed
     */
    public $selected;

    /**
     * @var boolean
     */
    public $settings;
    public $update;
    public $delete;

    /**
     * @var array
     */
    public $values;

    protected $listeners = [
        'createdExpense' => 'reloadVariables',
        'deletedExpense' => 'reloadVariables'
    ];

    /**
     * @var array
     */
    public $rules = [
        'name'             => 'required|string|max:255',
        'color'            => 'nullable|string|max:7',
        'finance_group_id' => 'required|integer|exists:App\Models\Finance\Group,id',
    ];

    /**
     * Mount the component
     *
     * @param \App\Models\Finance\Group $group
     */
    public function mount(GroupModel $group)
    {
        $this->group = $group;
        $this->categories = $group->Categories->toArray();

        $this->selected = '';
        $this->settings = false;
        $this->update = false;
        $this->delete = false;

        $this->values = [
            'name'             => '',
            'color'            => '',
            'finance_group_id' => $this->group->id,
        ];
    }

    /**
     * Create a new instance in the front-end
     *
     * @return array
     */
    public function new()
    {
        return $this->values = [
            'name'             => '',
            'color'            => '',
            'finance_group_id' => $this->group->id,
        ];
    }

    /**
     * toggle settings variable
     *
     * @return bool
     */
    public function toggleSettings()
    {
        return $this->settings = !$this->settings;
    }

    /**
     * Create a Category
     *
     * @param array $values
     *
     * @return mixed
     */
    public function create()
    {
        $this->values['finance_group_id'] = $this->group->id;
        $values = Validator::validate($this->values, $this->rules);

        $category = new Category($values);
        $category->save();

        $this->emit('createdCategory');

        return $this->reloadVariables();
    }

    /**
     * Prepare for update in the front-end
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
        $category = Category::find($id);

        $this->values = [
            'name' => $category->name,
            'color' => $category->color,
            'finance_group_id' => $category->finance_group_id
        ];

        return $this->values;
    }

    /**
     * Cancel update
     */
    public function cancelUpdate()
    {
        return $this->reloadVariables();
    }

    /**
     * Update a Category
     *
     * @return mixed
     */
    public function update()
    {
        $values = Validator::validate($this->values, $this->rules);
        $category = Category::find($this->selected);

        $category->update($values);

        $this->emit('updatedCategory');

        $this->update = false;
        return $this->reloadVariables();
    }

    /**
     * Prepare for delete in the front-end
     *
     * @param int $id
     *
     * @return array
     */
    public function prepareDelete(int $id)
    {
        $this->reloadVariables();

        $this->delete = true;
        $this->selected = $id;
        $category = Category::find($id);

        return $this->selected;
    }


    /**
     * Delete a Category
     *
     * @param \App\Models\Finance\Category $category
     *
     * @return mixed
     * @throws \Exception
     */
    public function delete() {
        Category::find($this->selected)->delete();

        $this->emit('deletedCategory');

        return $this->reloadVariables();
    }

    /**
     * Cancel Delete
     *
     * @return mixed
     */
    public function cancelDelete()
    {
        return $this->reloadVariables();
    }

    /**
     * Reload the Categories
     *
     * @return mixed
     */
    public function reloadVariables ()
    {
        $this->values = [];
        $this->selected = '';

        if($this->update === true) {
            $this->update = false;
        }

        if($this->delete === true) {
            $this->delete = false;
        }

        return $this->categories = $this->group->load('Categories')->Categories->toArray();
    }

    /**
     * Render the component
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('livewire.finance.categories', [
            'categories' => $this->categories,
            'selectedCategory' => $this->selected !== '' ? Category::findOrFail($this->selected)->toArray() : null,

            'settings' => $this->settings,
            'values' => $this->values
        ]);
    }
}
