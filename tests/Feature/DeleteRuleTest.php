<?php

namespace Tests\Feature;

use App\Http\Livewire\Managers\Rules\EditRules;
use App\Http\Livewire\Managers\Rules\NewRuleModal;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Rule;
use App\Models\User;
use Livewire\Livewire;
use App\Http\Livewire\Managers\Rules\ViewRulesList;

class DeleteRuleTest extends TestCase
{

    use RefreshDatabase;

    public function test_delete_rule()
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


        //Check rule exists in DB
        $dbAttributes = [
            'rule_name' => $rule->rule_name,
            'start_date' => $rule->start_date,
            'end_date' => $rule->end_date,
            'percentage' => $rule->percentage,
            'team_id' => $user->current_team_id
        ];
        $this->assertDatabaseHas('rules', $dbAttributes);


        //Remove the rule
        Livewire::test(EditRules::class, [
            'team' => $user->currentTeam,
            'message' => $rule->id,
            'rule_id' => $rule->id,
            'rule_name' => $rule->rule_name,
            'start_date' => $rule->start_date,
            'end_date' => $rule->end_date,
            'percentage' => $rule->percentage
        ])
            ->call('deleteRule')
            ->assertRedirect('rules');

        //Check the rule is not in the DB
        $doesntExistAttributes = [
            'id' => $rule->id,
            'team_id' => $user->current_team_id,
            'rule_name' => $rule->rule_name,
            'start_date' => $rule->start_date,
            'end_date' => $rule->end_date,
            'active' => 1,
            'percentage' => $rule->percentage,
        ];
        $this->assertDatabaseMissing('rules', $doesntExistAttributes);

        //Check the rule is not in the view
        Livewire::test(ViewRulesList::class, ['team' => $user->currentTeam])
            ->call('render')
            ->assertDontSee($rule);
    }
}
