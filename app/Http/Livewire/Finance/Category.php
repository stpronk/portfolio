<?php

namespace App\Http\Livewire\Finance;

use App\Models\Finance\Group as GroupModel;
use App\Models\Finance\Category as CategoryModel;
use Livewire\Component;

class Category extends Component
{
    public $group;

    public $category;

    /**
     * Used for updated the existing category
     *
     * @var array
     */
    public $categoryValues = [];

    public $rules = [
        'categoryValues.name'             => 'string|max:255',
        'categoryValues.color'            => 'string|max:7',
        'categoryValues.finance_group_id' => 'int|exists:App\Models\Finance\Group,id',
    ];

    public function mount(GroupModel $group, CategoryModel $category)
    {
        $this->group = $group;
        $this->category = $category;
    }

    public function update()
    {
        $this->validate();

        $this->category->name = $this->categoryValues['name'];
        $this->category->color = $this->categoryValues['color'];
        $this->category->finance_group_id = $this->categoryValues['finance_group_id'];

        $this->category->update();
        $this->categoryValues = [];

        $this->emitUp('updatedCategory');

        return $this->category;
    }

    public function delete()
    {
        $this->category->delete();

        $this->emitUp('deletedCategory');

        $this->category = null;
        $this->skipRender();

        return true;
    }

    public function render()
    {
        // -- Skip the render and return a string if the category is deleted ( Failsafe if the emit fails )
        if($this->shouldSkipRender) {
            return '';
        }

        return view('livewire.category', [
            'category' => $this->category->toArray()
        ]);
    }
}
