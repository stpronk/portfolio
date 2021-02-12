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
    public $new;
    public $update;

    /**
     * @var array
     */
    public $values;

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
        $this->new = false;
        $this->update = false;
        $this->values = [
            'name'             => '',
            'color'            => '',
            'finance_group_id' => $this->group->id,
        ];
    }

    /**
     * Create a new instance in the front-end
     *
     * @return bool
     */
    public function new()
    {
        $this->values = [];

        return $this->new = !$this->new;
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

        return $this->reloadCategories();
    }

    /**
     * Prepare for update in the front-end
     *
     * @return array
     */
    public function prepareUpdate()
    {
        if($this->selected === '') {
            return $this->reloadCategories();
        }

        $this->update = true;
        $category = Category::find($this->selected);

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
        $this->update = false;
        $this->values = [];
        $this->selected = '';
    }

    /**
     * Update a Category
     *
     * @param array                        $values
     * @param \App\Models\Finance\Category $category
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
        return $this->reloadCategories();
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

        return $this->reloadCategories();
    }

    /**
     * Reload the Categories
     *
     * @return mixed
     */
    private function reloadCategories ()
    {
        $this->values = [];
        $this->selected = '';

        if($this->new === true) {
            $this->new = false;
        }

        if($this->update === true) {
            $this->update = false;
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
            'selectedCategory' => $this->selected !== '' ? Category::findOrFail($this->selected)->toArray() : '',

            'new' => $this->new,
            'values' => $this->values
        ]);
    }
}
