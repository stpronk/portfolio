<?php

namespace Tests;

use App\Http\Livewire\Finance\Expenses as ExpensesLivewire;
use App\Http\Livewire\Finance\Group as GroupLivewire;
use App\Models\Finance\Category;
use App\Models\Finance\Expense;
use App\Models\Finance\Group;
use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Livewire\Livewire;
use App\Http\Livewire\Finance\Categories as CategoriesLivewire;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    // ------------------------ Global helper functions ------------------------ //

    /**
     * Login with a user account (Could be an admin account)
     *
     * @param bool $admin
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|mixed
     */
    public function login(bool $admin = false)
    {
        $this->actingAs($user = User::factory()->create([
            'is_admin' => $admin
        ]));

        return $user;
    }

    /**
     * Make a group based on the passed parameters.
     *
     * @param null|\App\Models\User $user
     * @param int                   $withCategories
     * @param int                   $withExpenses
     *
     * @return mixed
     * @throws \Exception
     */
    public function group(User $user = null, int $withCategories = 0, int $withExpenses = 0 )
    {
        $group = $this->makeGroups(1, $user)->first();

        if ( $withCategories ) {
            $categories = $this->makeCategories($withCategories, $group);
        }

        if ( $withExpenses ) {

            if( !$withCategories ) {
                Throw new \Exception('You can\'t make Expenses without a Categorie');
            }

            $categories->map(function ($category) use ($withExpenses, $group) {
                return $this->makeExpenses($withExpenses, $group, $category);
            });
        }

        $this->assertDatabaseCount('finance_group', 1)
            ->assertDatabaseCount('finance_category', $withCategories)
            ->assertDatabaseCount('finance_expense', $withExpenses);

        return $group;
    }

    /**
     * Make Group function
     *
     * @param int                   $count
     * @param null|\App\Models\User $user
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|mixed
     */
    protected function makeGroups(int $count = 1, User $user = null) {
        return Group::factory([
            'owner_id' => $user ? $user->id : User::factory()->create()->id
        ])->count(1)->create();
    }

    /**
     * Make Categories function
     *
     * @param int                            $count
     * @param null|\App\Models\Finance\Group $group
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|mixed
     */
    protected function makeCategories(int $count = 0, Group $group = null) {
        return Category::factory([
            'finance_group_id' => $group->id
        ])->count($count)->create();
    }

    /**
     * Make Expenses function
     *
     * @param int                               $count
     * @param null|\App\Models\Finance\Group    $group
     * @param null|\App\Models\Finance\Category $category
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|mixed
     */
    protected function makeExpenses (int $count = 0, Group $group = null, Category $category = null) {
        return Expense::factory([
            'finance_category_id' => $category->id,
            'finance_group_id' => $group->id
        ])->count($count)->create();
    }


    // ------------------------ Livewire instances ------------------------ //

    /**
     * Create a Group livewire instance
     *
     * @param \App\Models\Finance\Group $group
     *
     * @return \Livewire\Testing\TestableLivewire
     */
    public function groupLivewire(Group $group) {
        return Livewire::test(GroupLivewire::class, ['group' => $group]);
    }

    /**
     * Create a Category livewire instance
     *
     * @param \App\Models\Finance\Group $group
     *
     * @return \Livewire\Testing\TestableLivewire
     */
    public function categoryLivewire(Group $group) {
        return Livewire::test(CategoriesLivewire::class, ['group' => $group]);
    }

    /**
     * Create an Expense livewire instance
     *
     * @param \App\Models\Finance\Group $group
     *
     * @return \Livewire\Testing\TestableLivewire
     */
    public function expenseLivewire(Group $group) {
        return Livewire::test(ExpensesLivewire::class, ['group' => $group]);
    }

}
