<?php

namespace Tests\Unit\Finance\Livewire\Frontend;

use App\Models\Finance\Category;
use App\Models\Finance\Group;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    /**
     *
     */
    public function test_group_component_loads_the_correct_categories_into_itself_and_passes_it_through_to_the_view ()
    {
        $group = Group::factory()
            ->for(User::factory(), 'Owner')
            ->has(Category::factory()->count(3), 'Categories')
            ->create();

        $this->categoryLivewire($group)
            ->assertSet('categories', $group->Categories->toArray())
            ->assertViewHas('categories', $group->Categories->toArray());
    }
}
