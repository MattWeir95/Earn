<?php

namespace Tests\Feature;

use App\Http\Livewire\Managers\Dashboard\EmployeeList;
use App\Http\Livewire\Managers\Dashboard\Home;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Livewire\Livewire;

class ManagerHomeTest extends TestCase
{
    use RefreshDatabase;

    public function test_welcome_screen_renders_without_employees()
    {
        $this->actingAs($user = User::factory()->withPersonalTeam()->create());
        Livewire::test(Home::class, ['user' => $user])
            ->call('render')
            ->assertSeeHtml('Get your new Earn team started by inviting your team members');
    }

    public function test_employee_list_renders_with_employees()
    {
        $this->actingAs($user = User::factory()->withPersonalTeam()->create());
        $user->currentTeam->users()->attach(
            $otherUser = User::factory()->create(),
            ['role' => 'employee']
        );
        Livewire::test(Home::class, ['user' => $user])
            ->call('render')
            ->assertSeeHtml("widget-container");
    }

    public function test_correct_employee_list_data_one_employee()
    {
        $this->actingAs($user = User::factory()->withPersonalTeam()->create());
        $user->currentTeam->users()->attach(
            $otherUser = User::factory()->create(),
            ['role' => 'employee']
        );

        Livewire::test(EmployeeList::class, ['user' => $user])
            ->call('render')
            ->assertSee($otherUser->first_name, $otherUser->last_name, $otherUser->currentHistory($user->currentTeam));
    }

    public function test_correct_employee_list_data_many_employees()
    {
        $this->actingAs($user = User::factory()->withPersonalTeam()->create());

        $otherUsers = [];

        for($i = 0; $i < 4; $i++){
            $user->currentTeam->users()->attach(
                $otherUsers[$i] = User::factory()->create(),
                ['role' => 'employee']
            );
        }

        Livewire::test(EmployeeList::class, ['user' => $user])
            ->call('render')
            ->assertSee($otherUsers[0]->first_name, $otherUsers[0]->last_name, $otherUsers[0]->currentHistory($user->currentTeam))
            ->assertSee($otherUsers[1]->first_name, $otherUsers[1]->last_name, $otherUsers[1]->currentHistory($user->currentTeam))
            ->assertSee($otherUsers[2]->first_name, $otherUsers[2]->last_name, $otherUsers[2]->currentHistory($user->currentTeam))
            ->assertSee($otherUsers[3]->first_name, $otherUsers[3]->last_name, $otherUsers[3]->currentHistory($user->currentTeam));

    }
}
