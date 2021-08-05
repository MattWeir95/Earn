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

        Team::factory()->create();
        $this->actingAs($user = User::factory()->create());
        

        $attributes = [
            'new_rule_name' => "Test Rule",
            'new_start_date' => "2021-08-05",
            'new_end_date' => "2021-08-05",
            'new_percentage' =>82,
            'team_id' =>1    
        ];
  
        $this->post('addNewRule', $attributes)->assertRedirect('rules');

        $dbAttributes = [
            'rule_name' => "Test Rule",
            'start_date' => "2021-08-05",
            'end_date' => "2021-08-05",
            'percentage' =>82    ,
            'team_id' =>1    
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

        $attributes = [
            'new_start_date' => "2021-08-05",
            'new_end_date' => "2021-08-05",
            'new_percentage' =>82,
            'team_id' =>1    
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

        $attributes = [
            'rule_name' => "Test Rule",
            'new_end_date' => "2021-08-05",
            'new_percentage' =>82,
            'team_id' =>1    
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

        $attributes = [
            'rule_name' => "Test Rule",
            'new_start_date' => "2021-08-05",
            'new_percentage' =>82,
            'team_id' =>1    
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

        $attributes = [
            'rule_name' => "Test Rule",
            'new_start_date' => "2021-08-05",
            'new_end_date' => "2021-08-05",
            'team_id' =>1    
        ];
 
        $this->post('addNewRule', $attributes)->assertSessionHasErrors('new_percentage');
    }

    
}
