<?php

namespace Tests\Feature;

use App\Console\Commands\PopulateSales;
use App\Models\History;
use App\Models\Sale;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Team;
use App\Models\TeamUser;

class UserDSLTest extends TestCase
{
    use RefreshDataBase;


    public function test_one_team_user_entry()
    {
        $user = User::factory()->withPersonalTeam()->create();
        $t_u_entries = TeamUser::where('user_id',$user->id)->get();
        $this->assertCount(count($t_u_entries),$user->team_user_entries()->get());
        for ($i=0; $i < count($t_u_entries); $i++) { 
            $this->assertEquals($t_u_entries[$i]->id,$user->team_user_entries()->get()[$i]->id);
        }
    }
    
    public function test_multiple_team_user_entries()
    {
        $this->actingAs($user = User::factory()->withPersonalTeam()->create());
        Team::factory()->create()->users()->attach($user,['role'=>'manager']);
        $t_u_entries = TeamUser::where('user_id',$user->id)->get();
        $this->assertCount(count($t_u_entries), $user->team_user_entries()->get());
        for ($i = 0; $i < count($t_u_entries); $i++) {
            $this->assertEquals($t_u_entries[$i]->id, $user->team_user_entries()->get()[$i]->id);
        }
    }

    public function test_multiple_with_non_matching()
    {
        $this->actingAs($user = User::factory()->withPersonalTeam()->create());
        Team::factory()->create()->users()->attach($user, ['role' => 'manager']);
        User::factory()->onTeam($user->currentTeam)->create();
        $t_u_entries = TeamUser::where('user_id', $user->id)->get();
        $this->assertCount(count($t_u_entries), $user->team_user_entries()->get());
        for ($i = 0; $i < count($t_u_entries); $i++) {
            $this->assertEquals($t_u_entries[$i]->id, $user->team_user_entries()->get()[$i]->id);
        }
    }

    public function test_personal_team()
    {
        $user = User::factory()->withPersonalTeam()->create();
        $this->assertCount(1,$user->teams()->get());
        $this->assertEquals($user->currentTeam->name,$user->teams()->first()->name);
    }

    public function test_multiple_teams()
    {
        $old_user = User::factory()->withPersonalTeam()->create();
        $user = User::factory()->withPersonalTeam()->create();
        $old_user->currentTeam->users()->attach($user,['role'=>'employee']);
        $this->assertCount(2,$user->teams()->get());
    }

    public function test_histories()
    {
        $old_user = User::factory()->withPersonalTeam()->create();
        $user = User::factory()->onTeam($old_user->currentTeam)->create();
        PopulateSales::handle_without_console(90);
        $t_u = $user->team_user_entries()->get();
        $histories = array();
        foreach ($t_u as $tu) {
            foreach (History::where('team_user_id', $tu->id)->get() as $history) {
                array_push($histories,$history);
            }
        }
        $this->assertCount(count($histories),$user->histories()->get());
    }
    
    public function test_sales()
    {
        $old_user = User::factory()->withPersonalTeam()->create();
        $user = User::factory()->onTeam($old_user->currentTeam)->create();
        PopulateSales::handle_without_console(30);
        $t_u = $user->team_user_entries()->get();
        $sales = array();
        $this->assertCount(30, $user->sales()->get());
    }

    public function test_histories_for_team()
    {
        $manager_1 = User::factory()->withPersonalTeam()->create();
        $manager_2 = User::factory()->withPersonalTeam()->create();
        $user = User::factory()->onTeam($manager_1->currentTeam)->create();
        $manager_2->currentTeam->users()->attach($user,['role'=>'employee']);
        PopulateSales::handle_without_console(90);

        // Team 1
        $t_u = TeamUser::where('team_id',$manager_1->currentTeam->id)->firstWhere('user_id',$user->id);
        $histories = History::where('team_user_id',$t_u->id)->get();
        $this->assertCount(count($histories), $user->historiesForTeam($manager_1->currentTeam)->get());

        // Team 2
        $t_u = TeamUser::where('team_id', $manager_2->currentTeam->id)->firstWhere('user_id', $user->id);
        $histories = History::where('team_user_id', $t_u->id)->get();
        $this->assertCount(count($histories), $user->historiesForTeam($manager_2->currentTeam)->get());
    }

    public function test_sales_for_team()
    {
        $manager_1 = User::factory()->withPersonalTeam()->create();
        $manager_2 = User::factory()->withPersonalTeam()->create();
        $user = User::factory()->onTeam($manager_1->currentTeam)->create();
        $manager_2->currentTeam->users()->attach($user, ['role' => 'employee']);
        PopulateSales::handle_without_console(90);

        // Team 1
        $t_u = TeamUser::where('team_id', $manager_1->currentTeam->id)->firstWhere('user_id', $user->id);
        $sales = Sale::where('team_user_id', $t_u->id)->get();
        $this->assertCount(count($sales), $user->salesForTeam($manager_1->currentTeam)->get());

        // Team 2
        $t_u = TeamUser::where('team_id', $manager_2->currentTeam->id)->firstWhere('user_id', $user->id);
        $sales = Sale::where('team_user_id', $t_u->id)->get();
        $this->assertCount(count($sales), $user->salesForTeam($manager_2->currentTeam)->get());
    }

    public function test_current_history()
    {
        $user = User::factory()->withPersonalTeam()->create();
        $this->assertEquals(History::first(),$user->currentHistory($user->currentTeam));
    }
    // fwrite(STDERR, print_r($t_u_entries, TRUE));


}