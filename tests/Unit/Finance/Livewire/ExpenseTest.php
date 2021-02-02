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

        Livewire::test(ExpensesLivewire::class, ['group' => $group])
            ->assertSet('expenses', $group->Expenses->toArray())
            ->assertViewHas('expenses', $group->Expenses->toArray());
    }
}
