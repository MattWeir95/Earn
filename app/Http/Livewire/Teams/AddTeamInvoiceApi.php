<?php

namespace App\Http\Livewire\Teams;

use Livewire\Component;
use App\Models\InvoiceService;
use App\Models\InvoiceServiceToken;
use App\Http\Controllers\XeroController;
use Symfony\Component\VarDumper\VarDumper;

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

    //Define different service sign ins here.
    public function signin($service)
    {
        //Bug here where I can't get it to read the service name. By default everything takes you to xero currently.
        $test = new XeroController;
        $test->redirectUserToXero();
    }

}
