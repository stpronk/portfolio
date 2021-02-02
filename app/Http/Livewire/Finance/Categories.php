<?php

namespace App\Http\Livewire\Finance;

use App\Models\Finance\Category;
use \App\Models\Finance\Group as GroupModel;
use Livewire\Component;

class Categories extends Component
{
    public $group;

    public $categories = [];

    public $category = [];

    /**
     * @var array
     */
    public $rules = [
        'category.name'             => 'string|max:255',
        'category.color'            => 'string|max:7',
        'category.finance_group_id' => 'int|exists:App\Models\Finance\Group,id',
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
     * @return mixed
     */
    public function create()
    {
        $this->validate();

        $category = new Category($this->category);
        $category->save();

        $this->category = [];

        $this->emit('createdCategory');

        return $this->reloadCategories();
    }

    /**
     * Update a Category
     *
     * @param \App\Models\Finance\Category $category
     *
     * @return mixed
     */
    public function update(Category $category)
    {
        $this->validate();
//
//        $category->name = $this->category['name'];
//        $category->color = $this->category['color'];
//        $category->finance_group_id = $this->category['finance_group_id'];

        $category->update($this->category);

        $this->emit('updatedCategory');

        return $this->reloadCategories();
    }

    /**
     * Before delete
     *
     * @param \App\Models\Finance\Category $category
     *
     * @return bool
     */
    public function beforeDelete(Category $category)
    {
        $this->category = $category;

        return true;
    }

    /**
     * Cancel the delete
     *
     * @return bool
     */
    public function cancelDelete()
    {
        $this->category = [];

        return true;
    }

    /**
     * Delete a Category
     *
     * @return mixed
     */
    public function delete() {
        $this->category->delete();
        $this->category = [];

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
