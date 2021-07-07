<?php

namespace App\Http\Livewire\Teams;

use Livewire\Component;
use App\Models\InvoiceService;
use App\Models\InvoiceServiceToken;
use App\Http\Controllers\XeroController;

class AddTeamInvoiceApi extends Component
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
        $activeServices = InvoiceServiceToken::select('app_name')->where('team_id' ,$this->team->id)->get();
        $unactiveServices = InvoiceService::select('app_name')->whereNotIn('app_name', $activeServices)->get();
        
        return view('livewire.teams.add-team-invoice-api', [
            'services' => $unactiveServices
        ]);
    }

    public function signin($service)
    {
        $test = new XeroController;
        $test->redirectUserToXero();
    }

}
