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




class EditRuleTest extends TestCase
{
    use RefreshDataBase;

    
    /**
     * Test Post route for editing a rule redirects
     * Test Rule is created in the DB
     * Test Rule is shown on the view
     * Test Rule has been edited in the DB
     * Test Rule has been edited in the view
     *
     * @return void
     */
    public function test_edit_rule(){

        Team::factory()->create();
        $this->actingAs($user = User::factory()->create());
        $rule = Rule::factory()->make();

        //Insert a rule
        $attributes = [
            'new_rule_name' => $rule->rule_name,
            'new_start_date' => $rule->start_date,
            'new_end_date' => $rule->end_date,
            'new_percentage' =>$rule->percentage,
            'team_id' => $user->current_team_id    
        ];
  
        $this->post('addNewRule', $attributes)->assertRedirect('rules');

        //Check rule is in the DB
        $dbAttributes = [
            'rule_name' => $rule->rule_name,
            'start_date' => $rule->start_date,
            'end_date' => $rule->end_date,
            'percentage' =>$rule->percentage    ,
            'team_id' =>$user->current_team_id     
        ];
        $this->assertDatabaseHas('rules', $dbAttributes);

        //Check the values are on the livewire component
        Livewire::test(ViewRulesList::class, ['team' => $user->currentTeam])
                    ->call('render')
                    ->assertSee($attributes['new_percentage'], $attributes['new_rule_name']);


        //Edit the rule
        $EditRuleAttributes = [
            'id' => $rule->id,
            'rule_name' => $rule->rule_name,
            'start_date' => $rule->start_date,
            'end_date' => $rule->end_date,
            'percentage' =>$rule->percentage,
            'submitButton' => 'Update'
        ];

        $this->post('editRule', $EditRuleAttributes)->assertRedirect('rules');


        //Check new rule is in the DB
        $dbAttributes = [
            'rule_name' => $rule->rule_name,
            'start_date' => $rule->start_date,
            'end_date' => $rule->end_date,
            'percentage' =>$rule->percentage    ,
            'team_id' =>$user->current_team_id    
        ];
        $this->assertDatabaseHas('rules', $dbAttributes);


        //Check the new values are on the livewire component
        Livewire::test(ViewRulesList::class, ['team' => $user->currentTeam])
                    ->call('render')
                    ->assertSee($rule->rule_name, $rule->percentage);
      
    }

}