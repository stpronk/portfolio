<?php

namespace Tests\Unit\Finance\Livewire;

use App\Http\Livewire\Finance\Group as GroupLivewire;
use App\Models\Finance\Group;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class GroupTest extends TestCase
{
    use RefreshDatabase;

    /**
     *
     */
    public function test_group_component_loads_the_correct_group_into_itself_and_passes_it_through_to_the_view ()
    {
        $group = Group::factory()
            ->for(User::factory(), 'Owner')
            ->create();

        Livewire::test(GroupLivewire::class, ['group' => $group])
            ->assertSet('group', $group)
            ->assertViewHas('group', $group);
    }
}