<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Jetstream\Http\Livewire\TeamMemberManager;
use Livewire\Livewire;
use Tests\TestCase;

class RemoveTeamMemberTest extends TestCase
{
    use RefreshDatabase;

    public function test_team_members_can_be_removed_from_teams()
    {
        $this->actingAs($user = User::factory()->withPersonalTeam()->create());

        $user->currentTeam->users()->attach(
            $otherUser = User::factory()->create(), ['role' => 'manager']
        );

        $component = Livewire::test(TeamMemberManager::class, ['team' => $user->currentTeam])
                        ->set('teamMemberIdBeingRemoved', $otherUser->id)
                        ->call('removeTeamMember');
                        
        //Manager is remaining member, can not have team with 0 members
        $this->assertCount(1, $user->currentTeam->fresh()->users);
    }

    public function test_only_team_owner_can_remove_team_members()
    {
        $user = User::factory()->withPersonalTeam()->create();

        $user->currentTeam->users()->attach(
            $otherUser = User::factory()->create(), ['role' => 'manager']
        );

        $this->actingAs($otherUser);

        $component = Livewire::test(TeamMemberManager::class, ['team' => $user->currentTeam])
                        ->set('teamMemberIdBeingRemoved', $user->id)
                        ->call('removeTeamMember')
                        ->assertStatus(403);
    }
}
