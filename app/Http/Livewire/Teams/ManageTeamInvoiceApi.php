<?php

namespace App\Http\Livewire\Teams;

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
        $services = InvoiceServiceToken::select('app_name')->where('team_id' ,$this->team->id)->get();
        return view('livewire.teams.manage-team-invoice-api', [
            'services' => $services
        ]);
    }

    public function signout($service)
    {
         $deleteQuery = InvoiceServiceToken::where(['app_name' => $service, 'team_id' => $this->team->id])
             ->delete();

        return back();
            
    }
}
