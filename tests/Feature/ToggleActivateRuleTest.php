<?php

namespace Tests\Feature;

use App\Http\Livewire\Managers\Rules\NewRuleModal;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Rule;
use App\Models\User;
use App\Models\Team;
use Livewire\Livewire;
use App\Http\Livewire\Managers\Rules\ViewRulesList;

class ToggleActivateRuleTest extends TestCase
{
    use RefreshDataBase;


    public function test_toggle_deActivate_rule()
    {
        $this->actingAs($user = User::factory()->withPersonalTeam()->create());
        $rule = Rule::factory()->make();
        
        //Insert the rule
        Livewire::test(NewRuleModal::class, [
            'rule_name' => $rule->rule_name,
            'start_date' => $rule->start_date,
            'end_date' => $rule->end_date,
            'percentage' => $rule->percentage
            ])
            ->call('insertRule');
        
        //Get the rule
        $Rules = $user->currentTeam->rules()->get();
        
        //Test the rules state before and after toggling its active status
        Livewire::test(ViewRulesList::class,['team' => $user->currentTeam])
            ->call('render')
            ->assertSee('text-green-200 ml-4 bi bi-check-circle transform hover:scale-125')
            ->call('toggleActive', $Rules[0])
            ->call('render')
            ->assertSee('ml-4 text-red-400 bi bi-x-circle transform hover:scale-125');
            
            
    }

    public function test_toggle_active_rule()
    {
        $this->actingAs($user = User::factory()->withPersonalTeam()->create());
        $rule = Rule::factory()->make();
        
        Livewire::test(NewRuleModal::class, [
            'rule_name' => $rule->rule_name,
            'start_date' => $rule->start_date,
            'end_date' => $rule->end_date,
            'percentage' => $rule->percentage
            ])
            ->call('insertRule');
        

            //Get the rule and set its active state to false
            $Rules = $user->currentTeam->rules()->get();
        
            $jsonRule = json_decode($Rules[0]);
            $newRule = Rule::find($jsonRule->id);
            $newRule->active= !$jsonRule->active; 
            $newRule->save();

            //Get the de activated rule
            $Rules = $user->currentTeam->rules()->get();

        //Test the rules state before and after toggling its active status
        Livewire::test(ViewRulesList::class,['team' => $user->currentTeam])
            ->call('render')
            ->assertSee('ml-4 text-red-400 bi bi-x-circle transform hover:scale-125')
            ->call('toggleActive', $Rules[0])
            ->call('render')
            ->assertSee('text-green-200 ml-4 bi bi-check-circle transform hover:scale-125');

            
            
    }
    


}