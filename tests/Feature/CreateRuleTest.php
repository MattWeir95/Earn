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




class CreateRuleTest extends TestCase
{
    use RefreshDataBase;

    
    /**
     * Test Post route for creating a rule redirects
     * Test Rule is created in the DB
     * Test Rule is shown on the view.
     *
     * @return void
     */
    public function test_create_rule(){

        $this->actingAs($user = User::factory()->withPersonalTeam()->create());
        $rule = Rule::factory()->make();

        $attributes = [
            'new_rule_name' => $rule->rule_name,
            'new_start_date' => $rule->start_date,
            'new_end_date' => $rule->end_date,
            'new_percentage' =>$rule->percentage,
            'team_id' =>$user->current_team_id
        ];
  
        $this->post('addNewRule', $attributes)->assertRedirect('rules');

        $dbAttributes = [
            'rule_name' => $rule->rule_name,
            'start_date' => $rule->start_date,
            'end_date' => $rule->end_date,
            'percentage' =>$rule->percentage    ,
            'team_id' =>$user->current_team_id    
        ];
        $this->assertDatabaseHas('rules', $dbAttributes);

        Livewire::test(ViewRulesList::class, ['team' => $user->currentTeam])
                    ->call('render')
                    ->assertSee($attributes['new_percentage'], $attributes['new_rule_name']);
      
    }


    

    /**
     * Test Rule rule_name validation
     *
     * @return void
     */
    public function test_rule_requires_name(){
        Team::factory()->create();

        $this->actingAs($user = User::factory()->create());
        $rule = Rule::factory()->make();

        $attributes = [
            'new_start_date' => $rule->start_date,
            'new_end_date' => $rule->end_date,
            'new_percentage' =>$rule->percentage,
            'team_id' =>$user->current_team_id 
        ];
 
        
        $this->post('addNewRule', $attributes)->assertSessionHasErrors('new_rule_name');
    }

    /**
     * Test Rule start_date validation
     *
     * @return void
     */
    public function test_rule_requires_start_date(){
        Team::factory()->create();

        $this->actingAs($user = User::factory()->create());
        $rule = Rule::factory()->make();

        $attributes = [
            'rule_name' => $rule->rule_name,
            'new_end_date' => $rule->end_date,
            'new_percentage' =>$rule->percentage,
            'team_id' =>$user->current_team_id 
        ];
 
        
        $this->post('addNewRule', $attributes)->assertSessionHasErrors('new_start_date');
    }

    /**
     * Test Rule end_date validation
     *
     * @return void
     */
    public function test_rule_requires_end_date(){
        Team::factory()->create();

        $this->actingAs($user = User::factory()->create());
        $rule = Rule::factory()->make();

        $attributes = [
            'rule_name' => $rule->rule_name,
            'new_start_date' => $rule->start_date,
            'new_percentage' =>$rule->percentage,
            'team_id' =>$user->current_team_id 
        ];
 
        $this->post('addNewRule', $attributes)->assertSessionHasErrors('new_end_date');
    }

    /**
     * Test Rule percentage validation
     *
     * @return void
     */
    public function test_rule_requires_percentage(){
        Team::factory()->create();

        $this->actingAs($user = User::factory()->create());
        $rule = Rule::factory()->make();

        $attributes = [
            'rule_name' => $rule->rule_name,
            'new_start_date' => $rule->start_date,
            'new_end_date' => $rule->end_date,
            'team_id' =>$user->current_team_id 
        ];
 
        $this->post('addNewRule', $attributes)->assertSessionHasErrors('new_percentage');
    }

    
}
