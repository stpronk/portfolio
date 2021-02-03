<?php

namespace Tests\Unit\Finance\Livewire;

use App\Http\Livewire\Finance\Expenses as ExpensesLivewire;
use App\Models\Finance\Expense;
use App\Models\Finance\Group;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ExpenseTest extends TestCase
{
    use RefreshDatabase;

    public function test_expenses_component_loads_the_correct_expenses_into_itself_and_passes_it_through_to_the_view ()
    {
        $group = Group::factory()
            ->for(User::factory(), 'Owner')
            ->has(Expense::factory()->count(3), 'Expenses')
            ->create();

        $this->expenseLivewire($group)
            ->assertSet('expenses', $group->Expenses->toArray())
            ->assertViewHas('expenses', $group->Expenses->toArray());
    }

    public function test_user_should_be_able_to_create_a_new_expense_while_being_validated () {

        $user  = $this->login();
        $group = $this->group($user);

        // -- Post wrong form
        $expense = Expense::factory([
            'name'             => [],
            'amount'           => 'not an integer',
            'finance_group_id' => $group->id,
        ])->make();

        $this->expenseLivewire($group)
            ->call('create', $expense->toArray())
            ->assertNotEmitted('createdExpense')
            ->assertHasErrors(['name' => 'string', 'amount' => 'integer']);;

        $this->assertDatabaseMissing('finance_expense', $expense->toArray());

        // -- Post correct form
        $expense = Expense::factory(['finance_group_id' => $group->id,])->make();

        $this->expenseLivewire($group)
            ->call('create', $expense->toArray())
            ->assertEmitted('createdExpense')
            ->assertViewHas('expenses', [ $group->Expenses->toArray()[] = Expense::where('name', $expense->name)->first()->toArray() ])
        ;

        $this->assertDatabaseHas('finance_expense', $expense->toArray());
    }

    public function test_user_should_be_able_to_updated_an_existing_expense_while_being_validated () {
        $user  = $this->login();
        $group = $this->group($user, 1, 3);
        $existingExpense = $group->Expenses->first();

        // -- Post wrong form
        $expense = [
            'id'               => $existingExpense->id,
            'name'             => [],
            'amount'           => 'not an integer',
            'finance_group_id' => $group->id,
        ];

        $this->expenseLivewire($group)
            ->call('update', $expense, $existingExpense)
            ->assertNotEmitted('updatedExpense')
            ->assertHasErrors(['name' => 'string', 'amount' => 'integer']);

        $this->assertDatabaseMissing('finance_expense', $expense);
        $this->assertDatabaseHas('finance_expense', $existingExpense->toArray());

        // -- Post correct form
        $expense = Expense::factory(['id' => $existingExpense->id, 'finance_group_id' => $group->id])->make();

        $existingExpenseArray = $existingExpense->toArray();

        $this->expenseLivewire($group)
            ->call('update', $expense->toArray(), $existingExpense)
            ->assertEmitted('updatedExpense')
            ->assertViewHas('expenses', $group->Expenses->toArray())
        ;

        $this->assertDatabaseHas('finance_expense', $expense->toArray());
        $this->assertDatabaseMissing('finance_expense', $existingExpenseArray);
    }

    public function test_user_should_be_able_to_delete_an_existing_expense () {
        // TODO: Create test
        $this->assertTrue(true);
    }
}
