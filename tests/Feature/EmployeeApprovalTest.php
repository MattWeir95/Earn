<?php

namespace Tests\Feature;

use App\Http\Livewire\Employees\OutstandingModal;
use App\Models\History;
use App\Models\TeamUser;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Livewire;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EmployeeApprovalTest extends TestCase
{

    use RefreshDatabase;

    //Modal does not render when no outstanding commissions for previous months
    public function test_employee_approval_not_rendered()
    {
        $test_commission = 100;
        $this->actingAs($user = User::factory()->withPersonalTeam()->create());
        $user->currentTeam->users()->attach(
            $otherUser = User::factory()->withPersonalTeam()->create(),
            ['role' => 'employee']
        );
        $team_user = TeamUser::where('user_id', $otherUser->id)->firstWhere('team_id', $user->currentTeam->id);

        //Current Month
        History::factory()->create([
            'team_user_id' => $team_user->id,
            'start_time' => now('AEST')->startOfMonth(),
            'end_time' => now('AEST')->endOfMonth(),
            'total_commission' => $test_commission
        ])->save();


        Livewire::test(OutstandingModal::class, ['user' => $otherUser])
            ->call('render')
            ->assertDontSeeHtml('id="approval-modal"')
            ->assertSeeHtml('id="no-approvals"');
    }

    //Modal renders when there are outstanding commissions
    public function test_employee_approval_rendered_with_outstanding()
    {
        $test_commission = 100;
        $this->actingAs($user = User::factory()->withPersonalTeam()->create());
        $user->currentTeam->users()->attach(
            $otherUser = User::factory()->withPersonalTeam()->create(),
            ['role' => 'employee']
        );

        //Switch Teams
        User::where('id', $otherUser->id)->update(['current_team_id' => $user->currentTeam->id]);
        $team_user = TeamUser::where('user_id', $otherUser->id)->firstWhere('team_id', $user->currentTeam->id);

        //Current Month
        $start_time = now('AEST')->startOfMonth();
        $end_time = now('AEST')->endOfMonth();
        History::factory()->create([
            'team_user_id' => $team_user->id,
            'start_time' => $start_time,
            'end_time' => $end_time,
            'total_commission' => $test_commission,
        ])->save();

        //Previous Month

        $start_time = now('AEST')->subMonth()->startOfMonth();
        $end_time = now('AEST')->subMonth()->endOfMonth();
        History::factory()->create([
            'team_user_id' => $team_user->id,
            'start_time' => $start_time,
            'end_time' => $end_time,
            'total_commission' => $test_commission,
        ])->save();

        Livewire::test(OutstandingModal::class, ['user' => $otherUser])
            ->call('render')
            ->assertSeeHtml('id="approval-modal"')
            ->assertSeeHtml("Total: $" . $test_commission)
            ->assertSeeHtml(Carbon::parse($start_time)->toFormattedDateString() . "-" . Carbon::parse($end_time)->toFormattedDateString());
    }

    //Commission can be approved

    public function test_employee_modal_approve_commission()
    {
        $test_commission = 100;
        $this->actingAs($user = User::factory()->withPersonalTeam()->create());
        $user->currentTeam->users()->attach(
            $otherUser = User::factory()->withPersonalTeam()->create(),
            ['role' => 'employee']
        );

        //Switch Teams
        User::where('id', $otherUser->id)->update(['current_team_id' => $user->currentTeam->id]);
        $team_user = TeamUser::where('user_id', $otherUser->id)->firstWhere('team_id', $user->currentTeam->id);

        //Current Month
        $start_time = now('AEST')->startOfMonth();
        $end_time = now('AEST')->endOfMonth();
        History::factory()->create([
            'team_user_id' => $team_user->id,
            'start_time' => $start_time,
            'end_time' => $end_time,
            'total_commission' => $test_commission,
        ])->save();

        //Previous Month
        $start_time = now('AEST')->subMonth()->startOfMonth();
        $end_time = now('AEST')->subMonth()->endOfMonth();
        History::factory()->create([
            'team_user_id' => $team_user->id,
            'start_time' => $start_time,
            'end_time' => $end_time,
            'total_commission' => $test_commission,
        ])->save();

        $approval_history = History::orderBy('end_time', 'asc')->first();
        Livewire::test(OutstandingModal::class, ['user' => $otherUser])
            ->call('render')
            ->assertSeeHtml('id="approval-modal"')
            ->call('approve', [$approval_history->id])
            ->assertSeeHtml('id="no-approvals"');

        $dbAttributes = [
            'team_user_id' => $team_user->id,
            'start_time' => $start_time,
            'end_time' => $end_time,
            'total_commission' => $test_commission,
            'flagged' => 0,
            'approved' => 1
        ];

        $this->assertDatabaseHas('histories', $dbAttributes);
    }

    //Commission can be flagged

    public function test_employee_modal_flag_commission()
    {
        $test_commission = 100;
        $this->actingAs($user = User::factory()->withPersonalTeam()->create());
        $user->currentTeam->users()->attach(
            $otherUser = User::factory()->withPersonalTeam()->create(),
            ['role' => 'employee']
        );

        //Switch Teams
        User::where('id', $otherUser->id)->update(['current_team_id' => $user->currentTeam->id]);
        $team_user = TeamUser::where('user_id', $otherUser->id)->firstWhere('team_id', $user->currentTeam->id);

        //Current Month
        $start_time = now('AEST')->startOfMonth();
        $end_time = now('AEST')->endOfMonth();
        History::factory()->create([
            'team_user_id' => $team_user->id,
            'start_time' => $start_time,
            'end_time' => $end_time,
            'total_commission' => $test_commission,
        ])->save();

        //Previous Month
        $start_time = now('AEST')->subMonth()->startOfMonth();
        $end_time = now('AEST')->subMonth()->endOfMonth();
        History::factory()->create([
            'team_user_id' => $team_user->id,
            'start_time' => $start_time,
            'end_time' => $end_time,
            'total_commission' => $test_commission,
        ])->save();

        $approval_history = History::orderBy('end_time', 'asc')->first();
        Livewire::test(OutstandingModal::class, ['user' => $otherUser])
            ->call('render')
            ->assertSeeHtml('id="approval-modal"')
            ->call('flag', [$approval_history->id])
            ->assertSeeHtml('id="no-approvals"');

        $dbAttributes = [
            'team_user_id' => $team_user->id,
            'start_time' => $start_time,
            'end_time' => $end_time,
            'total_commission' => $test_commission,
            'flagged' => 1,
            'approved' => 0
        ];

        $this->assertDatabaseHas('histories', $dbAttributes);
    }
}
