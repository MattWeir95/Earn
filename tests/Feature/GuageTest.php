<?php

namespace Tests\Feature;

use App\Http\Livewire\Employees\Guage;
use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Classes\InvoiceGenerator;
use App\Http\Controllers\ParsingController;
use Tests\TestCase;
use Livewire\Livewire;

class GuageTest extends TestCase
{
    use RefreshDatabase;

    public function test_correct_team_target()
    {
        $this->actingAs($user = User::factory()->withPersonalTeam()->create());
        $target = Team::where('id', $user->currentTeam->id)->first();
        $target = $target->target_commission;
        $user->currentTeam->users()->attach(
            $otherUser = User::factory()->create(),
            ['role' => 'employee']
        );
        $otherUser->switchTeam($user->currentTeam);
        Livewire::test(Guage::class, ['user' => $otherUser])
            ->call('render')
            ->assertSee('target: ' . $target);
    }

    public function test_update_employee_commission_target()
    {
        $this->actingAs($user = User::factory()->withPersonalTeam()->create());
        $attributes = [
            'new_target' => 350,
            'team' => $user->current_team_id
        ];

        $this->post('updateTarget', $attributes);
        $target = Team::where('id', $user->currentTeam->id)->first();
        $target = $target->target_commission;
        $user->currentTeam->users()->attach(
            $otherUser = User::factory()->create(),
            ['role' => 'employee']
        );
        $otherUser->switchTeam($user->currentTeam);
        Livewire::test(Guage::class, ['user' => $otherUser])
            ->call('render')
            ->assertSee('target: ' . $target);
    }

    // public function test_correct_employee_commission(){

    // }

    //Need parser explained to me
    //Ensuring guage stops rotating once greater then 100%

    //public function test_guage_target_edge_case(){
        // $this->actingAs($user = User::factory()->withPersonalTeam()->create());
        // $target = Team::where('id', $user->currentTeam->id)->first();
        // $target = $target->target_commission;
        // $user->currentTeam->users()->attach(
        //     $otherUser = User::factory()->create(),
        //     ['role' => 'employee']
        // );
        // $otherUser->switchTeam($user->currentTeam);

        // $gen = new InvoiceGenerator;
        // [$item, $invoice] = $gen->getPair();
        // $result = ParsingController::parseLineItem($item,$user->current_team_id);

        // Livewire::test(Guage::class, ['user' => $otherUser])
        //     ->call('render')
        //     ->assertSee('rotate(${(45 + (Math.floor(100) * 1.8))}deg');
   // }

    public function test_no_sales_history()
    {
        $this->actingAs($user = User::factory()->withPersonalTeam()->create());
        $target = Team::where('id', $user->currentTeam->id)->first();
        $target = $target->target_commission;
        $user->currentTeam->users()->attach(
            $otherUser = User::factory()->create(),
            ['role' => 'employee']
        );
        $otherUser->switchTeam($user->currentTeam);
        Livewire::test(Guage::class, ['user' => $otherUser])
            ->call('render')
            ->assertSee('No Sales Found');
    }
}
