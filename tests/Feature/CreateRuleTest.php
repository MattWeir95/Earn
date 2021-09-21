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
use Illuminate\Support\Facades\DB;

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
    public function test_create_rule()
    {

        $this->actingAs($user = User::factory()->withPersonalTeam()->create());
        $rule = Rule::factory()->make();

       Livewire::test(NewRuleModal::class, [
            'rule_name' => $rule->rule_name,
            'start_date' => $rule->start_date,
            'end_date' => $rule->end_date,
            'percentage' => $rule->percentage
            ])
            ->call('insertRule')
            ->assertRedirect('rules'); 


        $dbAttributes = [
            'rule_name' => $rule->rule_name,
            'start_date' => $rule->start_date,
            'end_date' => $rule->end_date,
            'percentage' => $rule->percentage,
            'team_id' => $user->current_team_id
        ];
        $this->assertDatabaseHas('rules', $dbAttributes);

        Livewire::test(ViewRulesList::class, ['team' => $user->currentTeam])
            ->call('render')
            ->assertSee($rule->percentage, $rule->rule_name);
    }


    /**
     * Test Rule rule_name validation
     *
     * @return void
     */
    public function test_rule_requires_name()
    {
 
        $this->actingAs($user = User::factory()->withPersonalTeam()->create());
        $rule = Rule::factory()->make();

       Livewire::test(NewRuleModal::class, [
            'start_date' => $rule->start_date,
            'end_date' => $rule->end_date,
            'percentage' => $rule->percentage
            ])
            ->call('insertRule')
            ->assertSee('The rule name field is required');
    }

    /**
     * Test Rule start_date validation
     *
     * @return void
     */
    public function test_rule_requires_start_date()
    {
    
        $this->actingAs($user = User::factory()->withPersonalTeam()->create());
        $rule = Rule::factory()->make();

       Livewire::test(NewRuleModal::class, [
            'rule_name' => $rule->rule_name,
            'end_date' => $rule->end_date,
            'percentage' => $rule->percentage
            ])
            ->call('insertRule')
            ->assertSee('The start date field is required');
    }
    

    /**
     * Test Rule end_date validation
     *
     * @return void
     */
    public function test_rule_requires_end_date()
    {
        $this->actingAs($user = User::factory()->withPersonalTeam()->create());
        $rule = Rule::factory()->make();

       Livewire::test(NewRuleModal::class, [
            'rule_name' => $rule->rule_name,
            'start_date' => $rule->start_date,
            'percentage' => $rule->percentage
            ])
            ->call('insertRule')
            ->assertSee('The end date field is required');
    }

    /**
     * Test Rule percentage validation
     *
     * @return void
     */
    public function test_rule_requires_percentage()
    {
        $this->actingAs($user = User::factory()->withPersonalTeam()->create());
        $rule = Rule::factory()->make();

       Livewire::test(NewRuleModal::class, [
            'rule_name' => $rule->rule_name,
            'start_date' => $rule->start_date,
            'end_date' => $rule->end_date
            ])
            ->call('insertRule')
            ->assertSee('The percentage field is required');
    }
}
