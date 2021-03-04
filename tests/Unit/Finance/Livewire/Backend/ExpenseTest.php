<?php

namespace Tests\Unit\Finance\Livewire\Backend;

use App\Models\Finance\Expense;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExpenseTest extends TestCase
{
    use RefreshDatabase;

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
            ->assertHasErrors(['name' => 'string']);

        $this->assertDatabaseMissing('finance_expense', $expense->toArray());

        // -- Post correct form
        $expense = Expense::factory(['finance_group_id' => $group->id,])->make()->toArray();

        $this->expenseLivewire($group)
            ->call('create', $expense)
            ->assertEmitted('createdExpense')
            ->assertViewHas('expenses', $group->load('Expenses')->Expenses->toArray())
        ;

        $expense['type'] = Expense::${$expense['type']};
        $this->assertDatabaseHas('finance_expense', $expense);
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
            ->assertHasErrors(['name' => 'string']);

        $this->assertDatabaseMissing('finance_expense', $expense);
//        $this->assertDatabaseHas('finance_expense', $existingExpense->toArray());

        // -- Post correct form
        $expense = Expense::factory(['id' => $existingExpense->id, 'finance_group_id' => $group->id])->make()->toArray();

        $this->expenseLivewire($group)
            ->call('update', $expense, $existingExpense)
            ->assertEmitted('updatedExpense')
            ->assertViewHas('expenses', $group->load('Expenses')->Expenses->toArray())
        ;

        $expense['type'] = Expense::${$expense['type']};

        $this->assertDatabaseHas('finance_expense', $expense);
    }

    public function test_user_should_be_able_to_delete_an_existing_expense () {
        $user  = $this->login();
        $group = $this->group($user, 1, 3);
        $expense = $group->Expenses->first();

        $this->expenseLivewire($group)
            ->call('delete', $expense)
            ->assertNotSet('expenses.*.id', $expense->id)
            ->assertEmitted('deletedExpense');


        // -- Assert that the finance expense record is still in the database but without the right ID
        $this->assertDatabaseCount('finance_expense', 2);
        $this->assertSame(0, Expense::where('id', $expense->id)->count());
    }
}
