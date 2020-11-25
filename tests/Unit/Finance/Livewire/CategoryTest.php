<?php

namespace Tests\Unit\Finance\Livewire;

use App\Http\Livewire\Finance\Categories as CategoriesLivewire;
use App\Models\Finance\Category;
use App\Models\Finance\Group;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_group_component_loads_the_correct_categories_into_itself_and_passes_it_through_to_the_view ()
    {
        $group = Group::factory()
            ->for(User::factory(), 'Owner')
            ->has(Category::factory()->count(3), 'Categories')
            ->create();

        Livewire::test(CategoriesLivewire::class, ['group' => $group])
            ->assertSet('categories', $group->Categories->toArray())
            ->assertViewHas('categories', $group->Categories->toArray());
    }

    public function test_user_should_be_able_to_create_a_new_category_while_being_validated ()
    {
        $user  = $this->login();
        $group = $this->group($user);

        // -- Post wrong form
        $category = [
            'name' => 'Some name',
            'color' => '9784326y38742',
            'finance_group_id' => 'Not a ID'
        ];

        Livewire::test(CategoriesLivewire::class, ['group' => $group])
            ->set('category', $category)
            ->call('create');

        $this->assertDatabaseMissing('finance_category', $category);

        // -- Post correct form
        $category = Category::factory(['finance_group_id' => $group->id])->make();

        Livewire::test(CategoriesLivewire::class, ['group' => $group])
            ->set('category', $category->toArray())
            ->call('create')
            ->assertViewHas('categories', [ $group->Categories->toArray()[] = Category::where('name', $category->name)->first()->toArray() ])
        ;

        $this->assertDatabaseHas('finance_category', $category->toArray());
    }

    public function test_user_should_be_able_to_updated_an_existing_category_while_being_validated ()
    {
        $user  = $this->login();
        $group = $this->group($user, 1);
        $existingCategory = $group->Categories->first();

        // -- Post wrong form
        $category = [
            'name' => 'Some name',
            'color' => '9784326y38742',
            'finance_group_id' => 'Not a ID'
        ];

        Livewire::test(CategoriesLivewire::class, ['group' => $group])
            ->set('category', $category)
            ->call('update', $existingCategory)
            ->assertHasErrors(['category.color' => 'max', 'category.finance_group_id' => 'integer']);

        $this->assertDatabaseMissing('finance_category', $category);
        $this->assertDatabaseHas('finance_category', $existingCategory->toArray());

        // -- Post correct form
        $category = Category::factory(['finance_group_id' => $group->id])->make();

        Livewire::test(CategoriesLivewire::class, ['group' => $group])
            ->set('category', $category->toArray())
            ->call('update', $existingCategory)
            ->assertViewHas('categories', $group->Categories->toArray())
        ;

        $this->assertDatabaseHas('finance_category', $category->toArray());
        $this->assertDatabaseMissing('finance_category', $existingCategory->pluck('name', 'color')->toArray());
    }

    public function test_user_should_be_able_to_delete_a_category_set_all_attached_expenses_to_null ()
    {
        $user  = $this->login();
        $group = $this->group($user, 1, 3);
        $category = $group->Categories->first();

        Livewire::test(CategoriesLivewire::class, ['group' => $group])
            ->set('category.id', $category->id)
            ->call('delete');
            // Assert it's not in the component anymore

        // -- Assert that the record is missing from the database

        // -- Assert that all expenses has been made null where the category was present
    }
}