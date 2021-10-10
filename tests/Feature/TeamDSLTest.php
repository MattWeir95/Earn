<?php

namespace Tests\Feature;

use App\Http\Livewire\Managers\Rules\NewRuleModal;
use App\Console\Commands\PopulateSales;
use App\Models\History;
use App\Models\Rule;
use App\Models\Sale;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Team;
use Livewire\Livewire;
use App\Models\TeamUser;
use Laravel\Jetstream\Http\Livewire\CreateTeamForm;

class TeamDSLTest extends TestCase
{
    use RefreshDataBase;


    public function test_team_users()
    {
        $user = User::factory()->withPersonalTeam()->create();
        $team = $user->currentTeam;
        $this->assertCount(1,$team->teamUsers()->get());
        User::factory()->onTeam($team)->create();
        $this->assertCount(2,$team->teamUsers()->get());
    }

    public function test_histories()
    {
        $manager = User::factory()->withPersonalTeam()->create();
        $team = $manager->currentTeam;
        $this->assertCount(0,$team->histories()->get());
        User::factory()->count(3)->onTeam($team)->create();

        $other_user = User::factory()->withPersonalTeam()->create();
        User::factory()->onTeam($other_user->currentTeam)->create();

        PopulateSales::handle_without_console(30);

        $histories = array();
        foreach ($team->teamUsers()->get() as $tu) {
            foreach (History::where('team_user_id',$tu->id)->get() as $history) {
                array_push($histories,$history);
            }
        }
        $this->assertCount(count($histories), $team->histories()->get());
    }

    public function test_sales()
    {
        $manager = User::factory()->withPersonalTeam()->create();
        $team = $manager->currentTeam;
        $this->assertCount(0, $team->sales()->get());
        User::factory()->count(3)->onTeam($team)->create();

        $other_user = User::factory()->withPersonalTeam()->create();
        User::factory()->onTeam($other_user->currentTeam)->create();

        PopulateSales::handle_without_console(30);

        $sales = array();
        foreach ($team->teamUsers()->get() as $tu) {
            foreach (Sale::where('team_user_id', $tu->id)->get() as $sale) {
                array_push($sales, $sale);
            }
        }
        $this->assertCount(count($sales), $team->sales()->get());
    }

    public function test_histories_for_user()
    {
        $manager = User::factory()->withPersonalTeam()->create();
        $team = $manager->currentTeam;
        $employee = User::factory()->onTeam($team)->create();
        User::factory()->onTeam($team)->create();

        PopulateSales::handle_without_console(30);
        $histories = History::where('team_user_id',TeamUser::firstWhere('user_id',$employee->id)->id)->get();
        $this->assertCount(count($histories), $team->historiesForUser($employee)->get());
    }

    public function test_sales_for_user()
    {
        $manager = User::factory()->withPersonalTeam()->create();
        $team = $manager->currentTeam;
        $employee = User::factory()->onTeam($team)->create();
        User::factory()->onTeam($team)->create();

        PopulateSales::handle_without_console(30);
        $sales = Sale::where('team_user_id', TeamUser::firstWhere('user_id', $employee->id)->id)->get();
        $this->assertCount(count($sales), $team->salesForUser($employee)->get());
    }

    public function test_users_of_role()
    {
        $manager = User::factory()->withPersonalTeam()->create();
        $team = $manager->currentTeam;
        $this->assertCount(1,$team->usersOfRole('manager')->get());
        $this->assertCount(0,$team->usersOfRole('employee')->get());
        for ($i = 0; $i < 5; $i++) {
            $team->users()->attach(User::factory()->create(),['role'=>'employee']);
        }
        $team->users()->attach(User::factory()->create(), ['role' => 'manager']);
        $this->assertCount(2, $team->usersOfRole('manager')->get());
        $this->assertCount(5, $team->usersOfRole('employee')->get());
    }

    public function test_rules()
    {
        $manager = User::factory()->withPersonalTeam()->create();
        $team = $manager->currentTeam;
        $this->assertCount(0, $team->rules()->get());
        $this->actingAs($manager);
        $rule = Rule::factory()->make();

        Livewire::test(NewRuleModal::class, [
            'rule_name' => $rule->rule_name,
            'start_date' => $rule->start_date,
            'end_date' => $rule->end_date,
            'percentage' => $rule->percentage
        ])
            ->call('insertRule')
            ->assertRedirect('rules');
        
        $this->assertCount(1,$team->rules()->get());

    }
    
    // fwrite(STDERR, print_r($t_u_entries, TRUE));


}