<?php

namespace Tests\Feature;

use App\Http\Livewire\Managers\Rules\NewRuleModal;
use App\Console\Commands\PopulateSales;
use App\Http\Controllers\PredictionController;
use App\Models\History;
use App\Models\Rule;
use App\Models\Sale;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Team;
use Livewire\Livewire;
use App\Models\TeamUser;
use Carbon\Carbon;
use Laravel\Jetstream\Http\Livewire\CreateTeamForm;

class ProjectionTest extends TestCase
{
    use RefreshDataBase;


    public function test_target()
    {
        $user = User::factory()->withPersonalTeam()->create();
        $this->actingAs($user);
        $team = $user->currentTeam;
        $employee = User::factory()->onTeam($team)->create();
        NewRuleModal::insert_without_check('test rule',now()->subMonths(5),now()->addMonth(),5);
        $this->assertEquals($team->target_commission,PredictionController::getTarget($employee,$team));
        PopulateSales::handle_without_console(90);
        $this->assertNotEquals($team->target_commission,PredictionController::getTarget($employee,$team));
    }

    public function test_predict_next_month()
    {
        Carbon::setTestNow(now()->subMonths(5)->endOfMonth()->subDay());
        $manager = User::factory()->withPersonalTeam()->create();
        $this->actingAs($manager);
        $team = $manager->currentTeam;
        $employee = User::factory()->onTeam($team)->create();
        NewRuleModal::insert_without_check('test rule', now()->subYear(), now()->addMonths(2), 5);
        PopulateSales::handle_without_console(180);
        $prediction = PredictionController::predict($employee,$team)[0];
        Carbon::setTestNow(now()->addMonth());
        PopulateSales::handle_without_console(30);
        $actual = PredictionController::extrapolateThisMonth($employee,$team);
        $relative_error = round(abs($prediction-$actual) / $actual * 100);
        fprintf(STDERR,"\tPred: " . $prediction);
        fprintf(STDERR,"\n\tActual: " . $actual);
        fprintf(STDERR,"\n\tRelative Error: " . $relative_error . "%%\n");
        $this->assertNotNull($prediction);
        // $this->assertLessThan(50,$relative_error);
    }



}