<?php

namespace Tests\Feature;

use App\Http\Livewire\Managers\Rules\EditRules;
use App\Http\Livewire\Managers\Rules\NewRuleModal;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Rule;
use App\Models\User;
use App\Models\Team;
use Livewire\Livewire;
use App\Http\Livewire\Managers\Rules\ViewRulesList;
use Carbon\Carbon;




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
        $this->actingAs($user = User::factory()->withPersonalTeam()->create());
        $rule = Rule::factory()->make();

        //Insert a rule
        Livewire::test(NewRuleModal::class, [
            'rule_name' => $rule->rule_name,
            'start_date' => $rule->start_date,
            'end_date' => $rule->end_date,
            'percentage' => $rule->percentage
            ])
            ->call('insertRule')
            ->assertRedirect('rules'); 

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
                    ->assertSee($dbAttributes['percentage'], $dbAttributes['rule_name']);


        //Edit the rule
        $newRule = Rule::factory()->make();

        Livewire::test(EditRules::class, [
            'team' => $user->currentTeam,
            'message' => $rule->id,
            'rule_name' => $newRule->rule_name,
            'start_date' => $newRule->start_date,
            'end_date' => $newRule->end_date,
            'percentage' => $newRule->percentage,    
            ])
            ->call('editRule');


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

    public function test_edit_rule_name_exceeds_limit(){
        $this->actingAs($user = User::factory()->withPersonalTeam()->create());
        $rule = Rule::factory()->make();

        //Insert a rule
        Livewire::test(NewRuleModal::class, [
            'rule_name' => $rule->rule_name,
            'start_date' => $rule->start_date,
            'end_date' => $rule->end_date,
            'percentage' => $rule->percentage
            ])
            ->call('insertRule');


        //Edit the rule
        $newRule = Rule::factory()->make();
        $newRule->rule_name = 1123456789123456;

        Livewire::test(EditRules::class, [
            'team' => $user->currentTeam,
            'message' => $rule->id,
            'rule_name' => $newRule->rule_name,
            'start_date' => $newRule->start_date,
            'end_date' => $newRule->end_date,
            'percentage' => $newRule->percentage,    
            ])
            ->call('editRule')
            ->assertSee('The rule name must not be greater than 15 characters.');     
    }

    public function test_edit_rule_endDate_before_start_date(){
        $this->actingAs($user = User::factory()->withPersonalTeam()->create());
        $rule = Rule::factory()->make();
        $start_date = Carbon::create(2020, 2, 2, 0);
        $end_date_pass = Carbon::create(2021, 2, 2, 0);
        $end_date_fail = Carbon::create(2019, 2, 2, 0);


        //Insert a rule
        Livewire::test(NewRuleModal::class, [
            'rule_name' => $rule->rule_name,
            'start_date' => $start_date,
            'end_date' => $end_date_pass,
            'percentage' => $rule->percentage
            ])
            ->call('insertRule');


        //Edit the rule to have a end date before start date
        $newRule = Rule::factory()->make();
        

        Livewire::test(EditRules::class, [
            'team' => $user->currentTeam,
            'message' => $rule->id,
            'rule_name' => $newRule->rule_name,
            'start_date' => $start_date,
            'end_date' => $end_date_fail,
            'percentage' => $newRule->percentage,    
            ])
            ->call('editRule')
            ->assertSee('The end date must be a date after or equal to start date.');     
    }

    public function test_edit_rule_exceeding_percentage(){
        $this->actingAs($user = User::factory()->withPersonalTeam()->create());
        $rule = Rule::factory()->make();

        //Insert a rule
        Livewire::test(NewRuleModal::class, [
            'rule_name' => $rule->rule_name,
            'start_date' => $rule->start_date,
            'end_date' => $rule->end_date,
            'percentage' => $rule->percentage
            ])
            ->call('insertRule');


        //Edit the rule
        $newRule = Rule::factory()->make();
        $newRule->percentage= 1000;

        Livewire::test(EditRules::class, [
            'team' => $user->currentTeam,
            'message' => $rule->id,
            'rule_name' => $newRule->rule_name,
            'start_date' => $newRule->start_date,
            'end_date' => $newRule->end_date,
            'percentage' => $newRule->percentage,    
            ])
            ->call('editRule')
            ->assertSee('The percentage must be less than or equal 999.');     
    }

    public function test_edit_rule_negative_percentage(){
        $this->actingAs($user = User::factory()->withPersonalTeam()->create());
        $rule = Rule::factory()->make();

        //Insert a rule
        Livewire::test(NewRuleModal::class, [
            'rule_name' => $rule->rule_name,
            'start_date' => $rule->start_date,
            'end_date' => $rule->end_date,
            'percentage' => $rule->percentage
            ])
            ->call('insertRule');


        //Edit the rule
        $newRule = Rule::factory()->make();
        $newRule->percentage= -1;

        Livewire::test(EditRules::class, [
            'team' => $user->currentTeam,
            'message' => $rule->id,
            'rule_name' => $newRule->rule_name,
            'start_date' => $newRule->start_date,
            'end_date' => $newRule->end_date,
            'percentage' => $newRule->percentage,    
            ])
            ->call('editRule')
            ->assertSee('The percentage must be greater than 0.');     
    }

}