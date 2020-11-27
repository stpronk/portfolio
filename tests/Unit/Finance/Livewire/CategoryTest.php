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

        Livewire::test(CategoriesLivewire::class, ['group' => $group])
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
        $categoryValues = [
            'name' => 'Some name',
            'color' => '9784326y38742',
            'finance_group_id' => 'Not a ID'
        ];

        Livewire::test(CategoriesLivewire::class, ['group' => $group])
            ->set('categoryValues', $categoryValues)
            ->call('create');

        $this->assertDatabaseMissing('finance_category', $categoryValues);

        // -- Post correct form
        $categoryValues = Category::factory(['finance_group_id' => $group->id])->make();

        Livewire::test(CategoriesLivewire::class, ['group' => $group])
            ->set('categoryValues', $categoryValues->toArray())
            ->call('create')
            ->assertViewHas('categories', [ $group->Categories->toArray()[] = Category::where('name', $categoryValues->name)->first()->toArray() ])
        ;

        $this->assertDatabaseHas('finance_category', $categoryValues->toArray());
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
        $categoryValues = [
            'name' => 'Some name',
            'color' => '9784326y38742',
            'finance_group_id' => 'Not a ID'
        ];

        Livewire::test(CategoryLivewire::class, ['group' => $group, 'category' => $existingCategory])
            ->set('categoryValues', $categoryValues)
            ->call('update')
            ->assertHasErrors(['categoryValues.color' => 'max', 'categoryValues.finance_group_id' => 'integer']);

        $this->assertDatabaseMissing('finance_category', $categoryValues);
        $this->assertDatabaseHas('finance_category', $existingCategory->toArray());

        // -- Post correct form
        $categoryValues = Category::factory(['finance_group_id' => $group->id])->make();

        Livewire::test(CategoryLivewire::class, ['group' => $group, 'category' => $existingCategory])
            ->set('categoryValues', $categoryValues->toArray())
            ->call('update', $existingCategory)
            ->assertEmitted('updatedCategory');

        $this->assertDatabaseHas('finance_category', $categoryValues->toArray());
        $this->assertDatabaseMissing('finance_category', $existingCategory->pluck('name', 'color')->toArray());
    }

    /**
     * @throws \Exception
     */
    public function test_user_should_be_able_to_delete_a_category_set_all_attached_expenses_to_null ()
    {
        $user  = $this->login();
        $group = $this->group($user, 1, 3);
        $category = $group->Categories->first();

        // -- Check the expense before they get deleted and afterwards
        $this->assertSame(3, Expense::where('finance_category_id', $category->id)->count());

        // -- Create the test on the livewire class
        Livewire::test(CategoryLivewire::class, ['group' => $group, 'category' => $category])
            ->call('delete')
            ->assertEmitted('deletedCategory')
            ->assertSet('category', null);

        // -- Assert that the record is missing from the database
        $this->assertDatabaseMissing('finance_category', $category->toArray());

        // -- Assert that the finance expense record is still in the database but without the right ID
        $this->assertDatabaseCount('finance_expense', 3);
        $this->assertSame(0, Expense::where('finance_category_id', $category->id)->count());
    }
}