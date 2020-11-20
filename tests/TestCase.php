<?php

namespace Tests;

use App\Models\Finance\Category;
use App\Models\Finance\Expense;
use App\Models\Finance\Group;
use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use phpDocumentor\Reflection\Types\Integer;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function login(bool $admin = false)
    {
        $this->actingAs($user = User::factory()->create([
            'is_admin' => $admin
        ]));

        return $user;
    }

    public function createGroup(User $user = null, int $withCategories = 0, int $withExpenses = 0 )
    {
        $group = Group::factory([
            'owner_id' => $user ? $user->id : User::factory()->create()->id
        ]);

        if ( $withCategories ) {
            $categories = Category::factory()
                ->for($group, 'Group')
                ->count($withCategories)
                ->create();

            if ( $withExpenses ) {
                $categories->map(function ($category) use ($withExpenses){
                    Expense::factory([
                        'finance_category_id' => $category->id,
                        'finance_group_id' => $category->Group->id
                    ])->count($withExpenses)
                        ->create();
                });
            }

            return $categories->first()->Group;
        }

        return $group->create();
    }
}
