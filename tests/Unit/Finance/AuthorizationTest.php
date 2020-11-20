<?php

namespace Tests\unit\Finance;

use App\Models\Finance\Group;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthorizationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * User can access finance overview page
     *
     * @return void
     */
    public function test_user_can_access_finance_overview_page()
    {
        $response = $this->get('/finance');
        $response->assertStatus(302);

        $this->login();

        $response = $this->get('/finance');
        $response->assertStatus(200);
    }

    /**
     * User can access finance group
     *
     * @return void
     */
    public function test_user_can_access_a_finance_group ()
    {
        $user = User::factory()
            ->has(Group::factory(), 'FinanceGroups')
            ->create();

        $response = $this->get('/finance/' . $user->FinanceGroups->first()->id);
        $response->assertStatus(302);

        $this->actingAs($user);

        $response = $this->get('/finance/' . $user->FinanceGroups->first()->id);
        $response->assertStatus(200);
    }

    /**
     * User can not access a finance group while he is not the owner
     *
     * @return void
     */
    public function test_user_can_not_access_a_finance_group_while_he_is_not_the_owner()
    {
        $this->login();

        $user = User::factory()
            ->has(Group::factory(), 'FinanceGroups')
            ->create();

        $response = $this->get('/finance/' . $user->FinanceGroups->first()->id);
        $response->assertStatus(302);
    }

    /**
     * User can not access a finance group while he is not the owner
     *
     * @return void
     */
    public function test_user_has_access_to_the_create_function()
    {
        $this->post('/finance/store', Group::factory()->make()->toArray())
            ->assertLocation('/login');

        $user = $this->login();

        $this->post('/finance/store', Group::factory()->make(['owner_id' => $user->id])->toArray())
            ->assertLocation("/finance/1");
    }

    /**
     * Admin can access finance groups from other users
     *
     * @return void
     */
    public function test_admin_can_access_finance_groups_from_other_users ()
    {
        $this->login(true);

        $user = User::factory()
                ->has(Group::factory(), 'FinanceGroups')
                ->create();

        $response = $this->get('/finance/' . $user->FinanceGroups->first()->id);
        $response->assertStatus(200);
    }
}
