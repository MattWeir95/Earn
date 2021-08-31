<?php

namespace Tests\Feature;

use App\Classes\InvoiceGenerator;
use App\Http\Controllers\ParsingController;
use App\Http\Livewire\Employees\Guage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\History;
use App\Models\Team;
use App\Models\TeamUser;
use App\Models\User;
use App\Models\Rule;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Livewire\Livewire;

use function PHPUnit\Framework\assertSame;

class DevelopmentTest extends TestCase
{
    //use RefreshDatabase;

    public function test_populate_users_and_history()
    {
        $this->actingAs($user = User::factory()->withPersonalTeam()->create());
        $target = Team::where('id', $user->currentTeam->id)->first();
        $target = $target->target_commission;

        $otherUser = User::factory()->withPersonalTeam()->create();
        $otherUser2 = User::factory()->withPersonalTeam()->create();
        $user->currentTeam->users()->attach(
            $otherUser,
            ['role' => 'employee']
        );
        $user->currentTeam->users()->attach(
            $otherUser2,
            ['role' => 'employee']
        );

        $rule = Rule::factory()->make();
        $attributes = [
            'new_rule_name' => $rule->rule_name,
            'new_start_date' => $rule->start_date,
            'new_end_date' => $rule->end_date,
            'new_percentage' => $rule->percentage,
            'team_id' => $user->current_team_id
        ];

        $this->post('addNewRule', $attributes);
        
    }
}