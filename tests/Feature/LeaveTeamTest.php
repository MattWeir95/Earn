<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Jetstream\Http\Livewire\TeamMemberManager;
use Livewire\Livewire;
use Tests\TestCase;

class LeaveTeamTest extends TestCase
{
    use RefreshDatabase;

    public function test_users_can_leave_teams()
    {
        $user = User::factory()->withPersonalTeam()->create();

        $user->currentTeam->users()->attach(
            $otherUser = User::factory()->create(), ['role' => 'manager']
        );

        $this->actingAs($otherUser);

        $component = Livewire::test(TeamMemberManager::class, ['team' => $user->currentTeam])
                        ->call('leaveTeam');

        //Manager is remaining member, can not have team with 0 members
        $this->assertCount(1, $user->currentTeam->fresh()->users);
    }

    public function test_team_owners_cant_leave_their_own_team()
    {
        $this->actingAs($user = User::factory()->withPersonalTeam()->create());

        $component = Livewire::test(TeamMemberManager::class, ['team' => $user->currentTeam])
                        ->call('leaveTeam')
                        ->assertHasErrors(['team']);

        $this->assertNotNull($user->currentTeam->fresh());
    }
}
