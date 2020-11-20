<?php

namespace Tests\Unit\Finance;

use App\Models\Finance\Category;
use App\Models\Finance\Expense;
use App\Models\Finance\Group;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RelationsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * User has many Groups test
     *
     * @return void
     */
    public function test_user_has_many_groups ()
    {
        $user = User::factory()
            ->has(Group::factory()->count(3), 'FinanceGroups')
            ->create();

        /** Assert the amount of rows in the database */
        $this->assertEquals(3, $user->FinanceGroups->count());

        /** Assert if it is a instance of the Group model */
        $this->assertInstanceOf(Group::class, $user->FinanceGroups->first());
    }

    /**
     * Group has many Expenses test
     *
     * @return void
     */
    public function test_group_has_many_expenses ()
    {
        $group = Group::factory()
            ->has(Expense::factory()->count(3))
            ->create();

        /** Assert the amount of rows in the database */
        $this->assertEquals(3, $group->Expenses->count());

        /** Assert if it is a instance of the Expense model */
        $this->assertInstanceOf(Expense::class, $group->Expenses->first());
    }

    /**
     * Groups has many Categories test
     *
     * @return void
     */
    public function test_group_has_many_categories ()
    {
        $group = Group::factory()
            ->has(Category::factory()->count(3))
            ->create();

        /** Assert the amount of rows in the database */
        $this->assertEquals(3, $group->Categories->count());

        /** Assert if it is a instance of the Category model */
        $this->assertInstanceOf(Category::class, $group->Categories->first());
    }

    /**
     * Category belongs to Group test
     *
     * @return void
     */
    public function test_category_belongs_to_group ()
    {
        $category = Category::factory()
            ->for(Group::factory())
            ->create();

        /** Assert if it is a instance of the Category model */
        $this->assertInstanceOf(Group::class, $category->group);
    }

    /**
     * Category has many Expenses test
     *
     * @return void
     */
    public function test_category_has_many_expenses ()
    {
        $category = Category::factory()
            ->has(Expense::factory()->count(3))
            ->create();

        /** Assert the amount of rows in the database */
        $this->assertEquals(3, $category->Expenses->count());

        /** Assert if it is a instance of the Category model */
        $this->assertInstanceOf(Expense::class, $category->Expenses->first());
    }

    /**
     * Expense belongs to Group Test
     *
     * @return void
     */
    public function test_expense_belongs_to_group ()
    {
        $expense = Expense::factory()
            ->for(Group::factory())
            ->create();

        /** Assert if it is a instance of the Category model */
        $this->assertInstanceOf(Group::class, $expense->Group);
    }

    /***
     * Expense belongs To Category Test
     *
     * @return void
     */
    public function test_expenses_belongs_to_category()
    {
        $expense = Expense::factory()
            ->for(Category::factory())
            ->create();

        /** Assert if it is a instance of the Category model */
        $this->assertInstanceOf(Category::class, $expense->Category);
    }
}