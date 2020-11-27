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

    public $category = [];

    public $rules = [
        'category.name'             => 'string|max:255',
        'category.color'            => 'string|max:7',
        'category.finance_group_id' => 'int|exists:App\Models\Finance\Group,id',
    ];

    public function mount(GroupModel $group)
    {
        $this->group = $group;
        $this->categories = $group->Categories->toArray();
    }

    public function create()
    {
        // -- validate the content
        $this->validate();

        $category = new Category($this->category);
        $category->save();

        return $this->categories = $this->group->load('Categories')->Categories->toArray();
    }

    public function update(Category $category)
    {
        $this->validate();

        $category->name = $this->category['name'];
        $category->color = $this->category['color'];
        $category->finance_group_id = $this->category['finance_group_id'];

        $category->update();

        return $this->categories = $this->group->load('Categories')->Categories->toArray();
    }

    public function delete()
    {
        $category = Category::find($this->category['id']);
        $category->delete();

        return $this->category = [];
    }

    public function render()
    {
        return view('livewire.finance.categories', [
            'categories' => $this->categories
        ]);
    }
}
