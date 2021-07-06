<?php

namespace App\Http\Livewire\Teams;

use Livewire\Component;
use App\Models\InvoiceService;
use App\Models\InvoiceServiceToken;

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
        $allServices = InvoiceService::all();
        $activeServices = InvoiceServiceToken::where('team_id' ,$this->team->id)->get();

        $diff = $allServices->diff($activeServices)->all();

        return view('livewire.teams.add-team-invoice-api', [
            'services' => $diff
        ]);
    }

    public function signin($name)
    {
        return redirect('/test');
    }

}
