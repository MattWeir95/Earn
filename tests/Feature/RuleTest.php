<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Rule;
use App\Models\User;
use Livewire\Livewire;
use App\Http\Livewire\Managers\Rules\ViewRulesList;




class RulesTest extends TestCase
{
    
    // use RefreshDataBase;
    /**
     * Test Post route redirects
     * Test Rule is created in the DB
     * Test Rule is shown on the view.
     *
     * @return void
     */
    public function test_create_rule(){


        $this->actingAs($user = User::factory()->create());
        

        $attributes = [
            'new_rule_name' => "Public Holiday",
            'new_start_date' => "2021-08-05",
            'new_end_date' => "2021-08-05",
            'new_percentage' =>82,
            'team_id' =>1    
        ];

        $dbAttributes = [
            'rule_name' => "Public Holiday",
            'start_date' => "2021-08-05",
            'end_date' => "2021-08-05",
            'percentage' =>82    ,
            'team_id' =>1    
        ];
 
        
        $this->post('addNewRule', $attributes)->assertRedirect('rules');


        $this->assertDatabaseHas('rules', $dbAttributes);

        Livewire::test(ViewRulesList::class, ['team' => $user->currentTeam])
                    ->call('render')
                    ->assertSee($attributes['new_percentage'], $attributes['new_rule_name']);
      
    }
}
