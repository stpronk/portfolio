<?php

namespace Tests\Unit\Finance\Livewire;

use App\Http\Livewire\Finance\Categories as CategoriesLivewire;
use App\Http\Livewire\Finance\Category as CategoryLivewire;
use App\Models\Finance\Category;
use App\Models\Finance\Expense;
use App\Models\Finance\Group;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
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

    /**
     * @throws \Exception
     */
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

        $this->categoryLivewire($group)
            ->call('create', $category)
            ->assertNotEmitted('createdCategory')
            ->assertHasErrors(['color' => 'max', 'finance_group_id' => 'integer']);;

        $this->assertDatabaseMissing('finance_category', $category);

        // -- Post correct form
        $category = Category::factory(['finance_group_id' => $group->id])->make();

        $this->categoryLivewire($group)
            ->call('create', $category->toArray())
            ->assertEmitted('createdCategory')
            ->assertViewHas('categories', [ $group->Categories->toArray()[] = Category::where('name', $category->name)->first()->toArray() ])
        ;

        $this->assertDatabaseHas('finance_category', $category->toArray());
    }

    /**
     * @throws \Exception
     */
    public function test_user_should_be_able_to_updated_an_existing_category_while_being_validated ()
    {
        $user  = $this->login();
        $group = $this->group($user, 1);
        $existingCategory = $group->Categories->first();

        // -- Post wrong form
        $category = [
            'id' => $existingCategory->id,
            'name' => 'Some name',
            'color' => '9784326y38742',
            'finance_group_id' => 'Not a ID'
        ];

        $this->categoryLivewire($group)
            ->call('update', $category, $existingCategory)
            ->assertNotEmitted('updatedCategory')
            ->assertHasErrors(['color' => 'max', 'finance_group_id' => 'integer']);

        $this->assertDatabaseMissing('finance_category', $category);
        $this->assertDatabaseHas('finance_category', $existingCategory->toArray());

        // -- Post correct form
        $category = Category::factory(['id' => $existingCategory->id, 'finance_group_id' => $group->id])->make();

        $existingCategoryArray = $existingCategory->toArray();

        $this->categoryLivewire($group)
            ->call('update', $category->toArray(), $existingCategory)
            ->assertEmitted('updatedCategory')
            ->assertViewHas('categories', $group->Categories->toArray())
        ;

        $this->assertDatabaseHas('finance_category', $category->toArray());
        $this->assertDatabaseMissing('finance_category', $existingCategoryArray);
    }

    /**
     * @throws \Exception
     */
    public function test_user_should_be_able_to_delete_a_category_set_all_attached_expenses_to_null ()
    {
        $user  = $this->login();
        $group = $this->group($user, 1, 3);
        $category = $group->Categories->first();

        $this->categoryLivewire($group)
            ->call('delete', $category)
            ->assertNotSet('categories.*.id', $category->id)
            ->assertEmitted('deletedCategory');


        // -- Assert that the finance expense record is still in the database but without the right ID
        $this->assertDatabaseCount('finance_expense', 3);
        $this->assertSame(0, Expense::where('finance_category_id', $category->id)->count());
    }
}
