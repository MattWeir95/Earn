<?php

namespace Tests\Feature;

use App\Models\InvoiceServiceToken;
use App\Models\InvoiceService;
use App\Http\Livewire\Teams\ManageTeamInvoiceApi;
use App\Http\Livewire\Teams\AddTeamInvoiceApi;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Livewire\Livewire;

class ActiveInvoiceServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_sign_out_of_invoice_service()
    {
        $service = InvoiceService::factory()->create();

        $this->actingAs($user = User::factory()->withPersonalTeam()->create());
        $inputs = ['team_id' => $user->currentTeam->id, 'app_id' => $service->id, 'access_token' => '1234'];
        InvoiceServiceToken::create($inputs);

        Livewire::test(ManageTeamInvoiceApi::class, ['team' => $user->currentTeam])
            ->call('signout', $service->app_name);

        $result = InvoiceServiceToken::where(['team_id' => $user->currentTeam->id])->get();
        $this->assertCount(0, $result);
    }

    public function test_service_moved_from_available_to_active()
    {
        $service = InvoiceService::factory()->create();

        $this->actingAs($user = User::factory()->withPersonalTeam()->create());
        Livewire::test(AddTeamInvoiceApi::class, ['team' => $user->currentTeam])
            ->call('render')
            ->assertSee($service->app_name);

        Livewire::test(ManageTeamInvoiceApi::class, ['team' => $user->currentTeam])
            ->call('render')
            ->assertDontSee($service->app_name);

        $inputs = ['team_id' => $user->currentTeam->id, 'app_id' => $service->id, 'access_token' => '1234'];
        InvoiceServiceToken::create($inputs);

        Livewire::test(AddTeamInvoiceApi::class, ['team' => $user->currentTeam])
            ->call('render')
            ->assertDontSee($service->app_name);

        Livewire::test(ManageTeamInvoiceApi::class, ['team' => $user->currentTeam])
            ->call('render')
            ->assertSee($service->app_name);
    }

    public function test_service_signout_moves_from_active_to_available()
    {
        $service = InvoiceService::factory()->create();

        $this->actingAs($user = User::factory()->withPersonalTeam()->create());

        $inputs = ['team_id' => $user->currentTeam->id, 'app_id' => $service->id, 'access_token' => '1234'];
        InvoiceServiceToken::create($inputs);

        Livewire::test(AddTeamInvoiceApi::class, ['team' => $user->currentTeam])
            ->call('render')
            ->assertDontSee($service->app_name);

        Livewire::test(ManageTeamInvoiceApi::class, ['team' => $user->currentTeam])
            ->call('render')
            ->assertSee($service->app_name);

        Livewire::test(ManageTeamInvoiceApi::class, ['team' => $user->currentTeam])
            ->call('signout', ['Xero'])
            ->assertDontSee($service->app_name);

            Livewire::test(AddTeamInvoiceApi::class, ['team' => $user->currentTeam])
            ->call('render')
            ->assertSee($service->app_name);
    }
}
