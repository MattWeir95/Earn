<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\Livewire\Teams\ManageTeamTarget;
use App\Models\User;
use Tests\TestCase;
use Livewire\Livewire;

class SalesTargetTest extends TestCase
{
    use RefreshDatabase;

    public function test_sales_target_form_render()
    {
        $this->actingAs($user = User::factory()->withPersonalTeam()->create());
        Livewire::test(ManageTeamTarget::class, ['team' => $user->currentTeam])
            ->call('render')
            ->assertSee($user->currentTeam->target);
    }

    public function test_sales_target_updates()
    {
        $target = 123;
        $this->actingAs($user = User::factory()->withPersonalTeam()->create());
        Livewire::test(ManageTeamTarget::class, [
            'team' => $user->currentTeam,
            'target' => $target
        ])
            ->call('updateTarget')
            ->call('render')
            ->assertSeeHtml($target);


        $dbAttributes = [
            'user_id' => $user->id,
            'name' => $user->currentTeam->name,
            'personal_team' => 1,
            'target_commission' =>$target
        ];
        $this->assertDatabaseHas('teams', $dbAttributes);
    }

    public function test_sales_target_minimum()
    {
        $target = -1;
        $this->actingAs($user = User::factory()->withPersonalTeam()->create());
        Livewire::test(ManageTeamTarget::class, [
            'team' => $user->currentTeam,
            'target' => $target
        ])
            ->call('updateTarget')
            ->call('render')
            ->assertSeeHtml("Invalid Sales Target");
    }

    public function test_sales_target_maximum()
    {
        $target = 1001;
        $this->actingAs($user = User::factory()->withPersonalTeam()->create());
        Livewire::test(ManageTeamTarget::class, [
            'team' => $user->currentTeam,
            'target' => $target
        ])
            ->call('updateTarget')
            ->call('render')
            ->assertSeeHtml("Invalid Sales Target");
    }
}
