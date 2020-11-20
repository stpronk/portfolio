<?php

namespace Tests\Feature\Finance;

use App\Models\Finance\Category;
use App\Models\Finance\Group;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GroupTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_a_new_finance_group_and_redirects_to_the_new_group_page_while_being_validated ()
    {
        $user = $this->login();

        //--- Post different information to test the validation
        $group = [
            'name' => 'be',
            'owner_id' => 'some_owner'
        ];

        $this->post('/finance/store', $group)
            ->assertLocation('/'); // Redirect back to the last page which is the home page

        $this->assertDatabaseMissing('finance_group', $group);

        //--- Post a correct form
        $group = Group::factory(['owner_id' => $user->id])->make()->toArray();

        $this->post('/finance/store', $group)
            ->assertLocation("/finance/1"); // Redirect to the new group

        $this->assertDatabaseHas('finance_group', $group);
    }
}