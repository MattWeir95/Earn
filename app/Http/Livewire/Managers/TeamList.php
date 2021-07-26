<?php

namespace App\Http\Livewire\Managers;

use App\Models\InvoiceService;
use Livewire\Component;
use App\Models\InvoiceServiceToken;
use LangleyFoxall\XeroLaravel\XeroApp;
use League\OAuth2\Client\Token\AccessToken;

class TeamList extends Component
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
        $teamServices = InvoiceServiceToken::where('team_id', $this->team->id)->get();
        $response = $teamServices->count() . " invoice Services Activated";
        
        return view('livewire.managers.team-list', [
            'response' => $response,
            'services' => $teamServices
        ]);
    }
}
