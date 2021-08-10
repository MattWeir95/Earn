<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Rule;
use App\Models\User;
use App\Models\Team;
use Livewire\Livewire;
use App\Http\Livewire\Managers\Rules\ViewRulesList;

class DeleteRuleTest extends TestCase
{

    use RefreshDatabase;

    public function test_delete_rule(){

        Team::factory()->create();
        $this->actingAs($user = User::factory()->create());
        $rule = Rule::factory()->make();

        //Insert the rule
        $attributes = [
            'new_rule_name' => $rule->rule_name,
            'new_start_date' => $rule->start_date,
            'new_end_date' => $rule->end_date,
            'new_percentage' =>$rule->percentage,
            'team_id' =>$user->current_team_id    
        ];
  
        $this->post('addNewRule', $attributes)->assertRedirect('rules');


        //Check rule exists in DB
        $dbAttributes = [
            'rule_name' => $rule->rule_name,
            'start_date' => $rule->start_date,
            'end_date' => $rule->end_date,
            'percentage' =>$rule->percentage    ,
            'team_id' =>$user->current_team_id    
        ];
        $this->assertDatabaseHas('rules', $dbAttributes);


        //Remove the rule
        $removeRuleAttributes = [
            'id' => $rule->id,
            'rule_name' => $rule->rule_name,
            'start_date' =>  $rule->start_date,
            'end_date' => $rule->end_date,
            'percentage' =>$rule->percentage,
            'submitButton' => 'Remove'
        ];

        $this->post('editRule', $removeRuleAttributes)->assertRedirect('rules');

        //Check the rule is not in the DB
        $doesntExistAttributes = [
            'id' => $rule->id,
            'team_id' =>$user->current_team_id,
            'rule_name' => $rule->rule_name,
            'start_date' => $rule->start_date,
            'end_date' => $rule->end_date,
            'active'=>1,
            'percentage' =>$rule->percentage,
        ];
        $this->assertDatabaseMissing('rules', $doesntExistAttributes);

        //Check the rule is not in the view
        Livewire::test(ViewRulesList::class, ['team' => $user->currentTeam])
                    ->call('render')
                    ->assertDontSee($rule);
        
      
    }
}
