<?php

namespace App\Http\Livewire\Finance;

use App\Models\Finance\Category;
use \App\Models\Finance\Group as GroupModel;
use \Illuminate\Support\Facades\Validator;
use Livewire\Component;

class Categories extends Component
{
    public $group;

    public $categories = [];

    /**
     * @var array
     */
    public $rules = [
        'name'             => 'string|max:255',
        'color'            => 'string|max:7',
        'finance_group_id' => 'int|exists:App\Models\Finance\Group,id',
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
    }

    /**
     * Create a Category
     *
     * @param array $values
     *
     * @return mixed
     */
    public function create(array $values)
    {
        $values = Validator::validate($values, $this->rules);

        $category = new Category($values);
        $category->save();

        $this->emit('createdCategory');

        return $this->reloadCategories();
    }

    /**
     * Update a Category
     *
     * @param array                        $values
     * @param \App\Models\Finance\Category $existingCategory
     *
     * @return mixed
     */
    public function update(array $values, Category $existingCategory)
    {
        $values = Validator::validate($values, $this->rules);

        $existingCategory->update($values);

        $this->emit('updatedCategory');

        return $this->reloadCategories();
    }

    /**
     * Delete a Category
     *
     * @param \App\Models\Finance\Category $existingCategory
     *
     * @return mixed
     * @throws \Exception
     */
    public function delete(Category $existingCategory) {
        $existingCategory->delete();

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
            'categories' => $this->categories
        ]);
    }
}
