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
        


        //Insert the rule
        $attributes = [
            'new_rule_name' => "Test Rule",
            'new_start_date' => "2021-08-05",
            'new_end_date' => "2021-08-05",
            'new_percentage' =>82,
            'team_id' =>1    
        ];
  
        $this->post('addNewRule', $attributes)->assertRedirect('rules');


        //Check rule exists in DB
        $dbAttributes = [
            'rule_name' => "Test Rule",
            'start_date' => "2021-08-05",
            'end_date' => "2021-08-05",
            'percentage' =>82    ,
            'team_id' =>1    
        ];
        $this->assertDatabaseHas('rules', $dbAttributes);


        //Remove the rule
        $removeRuleAttributes = [
            'id' => 1,
            'rule_name' => "Test Rule2",
            'start_date' => "2021-08-05",
            'end_date' => "2021-08-05",
            'percentage' =>82,
            'submitButton' => 'Remove'
        ];

        $this->post('editRule', $removeRuleAttributes)->assertRedirect('rules');

        //Check the rule is not in the DB
        $doesntExistAttributes = [
            'id' => 1,
            'team_id' =>1,
            'rule_name' => "Test Rule2",
            'start_date' => "2021-08-05",
            'end_date' => "2021-08-05",
            'active'=>1,
            'percentage' =>82,
        ];
        $this->assertDatabaseMissing('rules', $doesntExistAttributes);

        //Check the rule is not in the view
        Livewire::test(ViewRulesList::class, ['team' => $user->currentTeam])
                    ->call('render')
                    ->assertDontSee($doesntExistAttributes['percentage'], $doesntExistAttributes['rule_name']);
        
      
    }
}
