<?php

namespace Tests\Feature;

use App\Http\Livewire\Managers\Dashboard\Home;
use App\Http\Livewire\Managers\Dashboard\OutstandingCarousel;
use App\Models\History;
use App\Models\TeamUser;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ManagerApprovalCarouselTest extends TestCase
{
    use RefreshDatabase;

    public function test_carousel_not_visible_if_no_approvals()
    {
        $this->actingAs($user = User::factory()->withPersonalTeam()->create());
        $user->currentTeam->users()->attach(
            $otherUser = User::factory()->create(),
            ['role' => 'employee']
        );
        Livewire::test(Home::class, ['user' => $user])
            ->call('render')
            ->assertSeeHtml('id="carousel-hidden"');
    }

    public function test_carousel_visible_when_approvals()
    {

        $test_commission = 100;
        $this->actingAs($user = User::factory()->withPersonalTeam()->create());

        $user->currentTeam->users()->attach(
            $otherUser = User::factory()->create(),
            ['role' => 'employee']
        );
        $team_user = TeamUser::where('user_id', $otherUser->id)->firstWhere('team_id', $user->currentTeam->id);

        History::factory()->create([
            'team_user_id' => $team_user->id,
            'start_time' => now('AEST')->subMonth()->startOfMonth(),
            'end_time' => now('AEST')->subMonth()->endOfMonth(),
            'total_commission' => $test_commission
        ])->save();

        Livewire::test(Home::class, ['user' => $user])
            ->call('render')
            ->assertSeeHtml('id="carousel-visible"');
    }

    public function test_carousel_commission_approval_no_remaining()
    {
        $test_commission = 100;
        $this->actingAs($user = User::factory()->withPersonalTeam()->create());

        $user->currentTeam->users()->attach(
            $otherUser = User::factory()->create(),
            ['role' => 'employee']
        );
        $team_user = TeamUser::where('user_id', $otherUser->id)->firstWhere('team_id', $user->currentTeam->id);

        History::factory()->create([
            'team_user_id' => $team_user->id,
            'start_time' => now('AEST')->subMonth()->startOfMonth(),
            'end_time' => now('AEST')->subMonth()->endOfMonth(),
            'total_commission' => $test_commission
        ])->save();

        $history_entry = History::first();
        Livewire::test(OutstandingCarousel::class, ['user' => $user])
            ->call('approve', [$history_entry->id]);

        $dbAttributes = [
            'team_user_id' => $team_user->id,
            'start_time' => now('AEST')->subMonth()->startOfMonth(),
            'end_time' => now('AEST')->subMonth()->endOfMonth(),
            'total_commission' => $test_commission,
            'flagged' => 0,
            'approved' => 1
        ];

        $this->assertDatabaseHas('histories', $dbAttributes);

        Livewire::test(Home::class, ['user' => $user])
            ->call('render')
            ->assertSeeHtml('id="carousel-hidden"');
    }

    public function test_carousel_commission_approval_remaining_approvals()
    {
        $test_commission = 100;
        $this->actingAs($user = User::factory()->withPersonalTeam()->create());

        $employees[] = null;
        for($i = 0; $i < 2; $i++){
            $user->currentTeam->users()->attach(
                $otherUser = User::factory()->create(),
                ['role' => 'employee']
            );

            $employees[$i] = TeamUser::where('user_id', $otherUser->id)->firstWhere('team_id', $user->currentTeam->id);
    
            History::factory()->create([
                'team_user_id' => $employees[$i]->id,
                'start_time' => now('AEST')->subMonth()->startOfMonth(),
                'end_time' => now('AEST')->subMonth()->endOfMonth(),
                'total_commission' => $test_commission
            ])->save();
        }

        $history_entry = History::first();
        Livewire::test(OutstandingCarousel::class, ['user' => $user])
            ->call('approve', [$history_entry->id]);

        $dbAttributes = [
            'team_user_id' => $employees[0]->id,
            'start_time' => now('AEST')->subMonth()->startOfMonth(),
            'end_time' => now('AEST')->subMonth()->endOfMonth(),
            'total_commission' => $test_commission,
            'flagged' => 0,
            'approved' => 1
        ];

        $this->assertDatabaseHas('histories', $dbAttributes);

        Livewire::test(Home::class, ['user' => $user])
            ->call('render')
            ->assertSeeHtml('id="carousel-visible"');
    }

    public function test_carousel_commission_rejection_no_remaining(){
        $test_commission = 100;
        $this->actingAs($user = User::factory()->withPersonalTeam()->create());

        $user->currentTeam->users()->attach(
            $otherUser = User::factory()->create(),
            ['role' => 'employee']
        );
        $team_user = TeamUser::where('user_id', $otherUser->id)->firstWhere('team_id', $user->currentTeam->id);

        History::factory()->create([
            'team_user_id' => $team_user->id,
            'start_time' => now('AEST')->subMonth()->startOfMonth(),
            'end_time' => now('AEST')->subMonth()->endOfMonth(),
            'total_commission' => $test_commission
        ])->save();

        $history_entry = History::first();
        Livewire::test(OutstandingCarousel::class, ['user' => $user])
            ->call('flag', [$history_entry->id]);

        $dbAttributes = [
            'team_user_id' => $team_user->id,
            'start_time' => now('AEST')->subMonth()->startOfMonth(),
            'end_time' => now('AEST')->subMonth()->endOfMonth(),
            'total_commission' => $test_commission,
            'flagged' => 1,
            'approved' => 0
        ];

        $this->assertDatabaseHas('histories', $dbAttributes);

        Livewire::test(Home::class, ['user' => $user])
            ->call('render')
            ->assertSeeHtml('id="carousel-hidden"');
    }

    public function test_carousel_commission_rejections_remaining_approvals()
    {
        $test_commission = 100;
        $this->actingAs($user = User::factory()->withPersonalTeam()->create());
        $employees[] = null;
        for($i = 0; $i < 2; $i++){
            $user->currentTeam->users()->attach(
                $otherUser = User::factory()->create(),
                ['role' => 'employee']
            );

            $employees[$i] = TeamUser::where('user_id', $otherUser->id)->firstWhere('team_id', $user->currentTeam->id);
    
            History::factory()->create([
                'team_user_id' => $employees[$i]->id,
                'start_time' => now('AEST')->subMonth()->startOfMonth(),
                'end_time' => now('AEST')->subMonth()->endOfMonth(),
                'total_commission' => $test_commission
            ])->save();
        }

        $history_entry = History::first();
        Livewire::test(OutstandingCarousel::class, ['user' => $user])
            ->call('flag', [$history_entry->id]);

        $dbAttributes = [
            'team_user_id' => $employees[0]->id,
            'start_time' => now('AEST')->subMonth()->startOfMonth(),
            'end_time' => now('AEST')->subMonth()->endOfMonth(),
            'total_commission' => $test_commission,
            'flagged' => 1,
            'approved' => 0
        ];

        $this->assertDatabaseHas('histories', $dbAttributes);

        Livewire::test(Home::class, ['user' => $user])
            ->call('render')
            ->assertSeeHtml('id="carousel-visible"');
    }
}
