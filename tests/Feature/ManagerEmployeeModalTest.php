<?php

namespace Tests\Feature;

use App\Http\Livewire\Managers\Dashboard\EmployeeModal;
use App\Models\History;
use App\Models\TeamUser;
use App\Models\User;
use Livewire\Livewire;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManagerEmployeeModalTest extends TestCase
{   
    use RefreshDatabase;

    public function test_employee_modal_renders_correct_data(){

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

        Livewire::test(EmployeeModal::class, ['user_id' => $otherUser->id, 'team' => $user->currentTeam])
            ->call('render')
            ->assertSeeHtml('id="employee-modal"')
            ->assertSeeHtml($otherUser->first_name . " " . $otherUser->last_name);

    }
}
