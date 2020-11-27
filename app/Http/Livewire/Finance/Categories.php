<?php

namespace App\Http\Livewire\Finance;

use App\Models\Finance\Category;
use \App\Models\Finance\Group as GroupModel;
use Livewire\Component;
use PhpParser\Node\Stmt\Foreach_;
use PhpParser\Node\Stmt\Return_;

class Categories extends Component
{
    public $group;

    public $categories = [];

    /**
     * Used for creating new categories
     *
     * @var array
     */
    public $categoryValues = [];

    /**
     * @var array
     */
    public $rules = [
        'categoryValues.name'             => 'string|max:255',
        'categoryValues.color'            => 'string|max:7',
        'categoryValues.finance_group_id' => 'int|exists:App\Models\Finance\Group,id',
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
     * Create a category
     *
     * @return mixed
     */
    public function create()
    {
        $this->validate();

        $category = new Category($this->categoryValues);
        $category->save();

        // -- empty the category
        $this->categoryValues = [];

        // -- Return with the new Category
        return $this->categories = $this->group->load('Categories')->Categories->toArray();
    }

    /**
     * Render the component
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('livewire.finance.categories', [
            'categories' => $this->categories
        ]);
    }
}
