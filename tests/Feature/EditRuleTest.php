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
        

        //Insert a rule
        $attributes = [
            'new_rule_name' => "Test Rule3",
            'new_start_date' => "2021-08-05",
            'new_end_date' => "2021-08-05",
            'new_percentage' =>82,
            'team_id' =>1    
        ];
  
        $this->post('addNewRule', $attributes)->assertRedirect('rules');

        //Check rule is in the DB
        $dbAttributes = [
            'rule_name' => "Test Rule3",
            'start_date' => "2021-08-05",
            'end_date' => "2021-08-05",
            'percentage' =>82    ,
            'team_id' =>1    
        ];
        $this->assertDatabaseHas('rules', $dbAttributes);

        //Check the values are on the livewire component
        Livewire::test(ViewRulesList::class, ['team' => $user->currentTeam])
                    ->call('render')
                    ->assertSee($attributes['new_percentage'], $attributes['new_rule_name']);


        //Edit the rule
        $EditRuleAttributes = [
            'id' => 1,
            'rule_name' => "Test Rule4",
            'start_date' => "2021-08-05",
            'end_date' => "2021-08-05",
            'percentage' =>83,
            'submitButton' => 'Update'
        ];

        $this->post('editRule', $EditRuleAttributes)->assertRedirect('rules');


        //Check new rule is in the DB
        $dbAttributes = [
            'rule_name' => "Test Rule4",
            'start_date' => "2021-08-05",
            'end_date' => "2021-08-05",
            'percentage' =>83    ,
            'team_id' =>1    
        ];
        $this->assertDatabaseHas('rules', $dbAttributes);


        //Check the new values are on the livewire component
        Livewire::test(ViewRulesList::class, ['team' => $user->currentTeam])
                    ->call('render')
                    ->assertSee($EditRuleAttributes['percentage'], $EditRuleAttributes['rule_name']);
      
    }

}