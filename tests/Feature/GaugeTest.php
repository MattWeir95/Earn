<?php

namespace Tests\Feature;

use App\Http\Livewire\Employees\Gauge;
use App\Http\Livewire\Teams\ManageTeamTarget;
use App\Models\History;
use App\Models\TeamUser;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Livewire\Livewire;

class GaugeTest extends TestCase
{
    use RefreshDatabase;

    public function test_correct_team_target()
    {
        $this->actingAs($user = User::factory()->withPersonalTeam()->create());
        $target = $user->currentTeam->target_commission;
        $user->currentTeam->users()->attach(
            $otherUser = User::factory()->create(),
            ['role' => 'employee']
        );
        $otherUser->switchTeam($user->currentTeam);
        Livewire::test(Gauge::class, ['user' => $otherUser, 'team' => $otherUser->currentTeam])
            ->call('render')
            ->assertSee('target: ' . $target);
    }

    public function test_update_employee_commission_target()
    {
        $this->actingAs($user = User::factory()->withPersonalTeam()->create());
        $new_target = 350;
        Livewire::test(ManageTeamTarget::class, [
            'team' => $user->currentTeam,
            'target' => $new_target
        ])
            ->call('updateTarget');
        $user->currentTeam->users()->attach(
            $otherUser = User::factory()->create(),
            ['role' => 'employee']
        );
        $otherUser->switchTeam($user->currentTeam);
        Livewire::test(Gauge::class, ['user' => $otherUser, 'team' => $otherUser->currentTeam])
            ->call('render')
            ->assertSee('target: ' . $new_target);
    }

    public function test_correct_employee_commission()
    {
        $this->actingAs($user = User::factory()->withPersonalTeam()->create());
        $target = $user->currentTeam->target_commission;
        $user->currentTeam->users()->attach(
            $otherUser = User::factory()->create(),
            ['role' => 'employee']
        );
        $otherUser->switchTeam($user->currentTeam);
        $teamUser = TeamUser::where('user_id', $otherUser->id)
            ->where('team_id', $otherUser->currentTeam->id)
            ->first();

        $history = History::factory()->create([
            'team_user_id' => $teamUser->id,
            'total_commission' => $target - 5
        ]);

        Livewire::test(Gauge::class, ['user' => $otherUser, 'team' => $otherUser->currentTeam])
            ->call('render')
            ->assertSee('earned: ' . $target - 5 . ', target: ' . $target);
    }

    //Ensuring Gauge stops rotating once greater then 100%

    public function test_gauge_target_edge_case()
    {
        $this->actingAs($user = User::factory()->withPersonalTeam()->create());
        $target = $user->currentTeam->target_commission;
        $user->currentTeam->users()->attach(
            $otherUser = User::factory()->create(),
            ['role' => 'employee']
        );
        $otherUser->switchTeam($user->currentTeam);
        $teamUser = TeamUser::where('user_id', $otherUser->id)
            ->where('team_id', $otherUser->currentTeam->id)
            ->first();

        $history = History::factory()->create([
            'team_user_id' => $teamUser->id,
            'total_commission' => $target + 100
        ]);

        Livewire::test(Gauge::class, ['user' => $otherUser, 'team' => $otherUser->currentTeam])
            ->call('render')
            ->assertSee('rotate(${(45 + (Math.floor(100) * 1.8))}deg');
    }

    public function test_no_sales_history()
    {
        $this->actingAs($user = User::factory()->withPersonalTeam()->create());
        $target = $user->currentTeam->target_commission;
        $user->currentTeam->users()->attach(
            $otherUser = User::factory()->create(),
            ['role' => 'employee']
        );
        $otherUser->switchTeam($user->currentTeam);
        Livewire::test(Gauge::class, ['user' => $otherUser, 'team' => $otherUser->currentTeam])
            ->call('render')
            ->assertSee('No Sales Found');
    }
}
