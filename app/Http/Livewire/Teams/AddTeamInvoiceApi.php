<?php

namespace App\Http\Livewire\Teams;

use Livewire\Component;
use App\Models\InvoiceService;
use App\Models\InvoiceServiceToken;
use App\Http\Controllers\XeroController;
use Symfony\Component\VarDumper\VarDumper;

class AddTeamInvoiceApi extends Component
{
    protected $listeners = ['serviceRemoved' => 'render'];
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
        $activeServices = $this->team->invoiceServiceTokens()->get();
        if(count($activeServices) > 0){
            $unactiveServices = InvoiceService::whereNotIn('id', $activeServices[0])->get();
        }
        else {
            $unactiveServices = InvoiceService::all();
        }
        return view('livewire.teams.add-team-invoice-api', [
            'services' => $unactiveServices
        ]);
    }

    //Define different service sign ins here.
    public function signin($service)
    {
        switch($service['app_name']){
            case "Xero":
                $x = new XeroController;
                $x->redirectUserToXero();
                break;
            default:
                back();
        }
    }

}
