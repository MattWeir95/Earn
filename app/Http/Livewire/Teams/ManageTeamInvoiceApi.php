<?php

namespace App\Http\Livewire\Teams;

use App\Models\InvoiceService;
use Livewire\Component;
use App\Models\InvoiceServiceToken;

class ManageTeamInvoiceApi extends Component
{

    /**
     * The team instance.
     *
     * @var mixed
     */
    public $team;

    /**
     * Mount the component.
     *
     * @param  mixed  $team
     * @return void
     */
    public function mount($team)
    {
        $this->team = $team;
    }

    public function render()
    {
        $services = $this->team->invoiceServiceTokens()->get()
            ->map(function ($token) {
                return $token->app_name;
            });
        return view('livewire.teams.manage-team-invoice-api', [
            'services' => $services
        ]);
    }

    public function signout($service)
    {
        $serviceId = InvoiceService::where(['app_name' => $service])->value('id');
        $deleteQuery = InvoiceServiceToken::where(['id' => $serviceId, 'team_id' => $this->team->id])
             ->delete();

        return back();
            
    }
}
