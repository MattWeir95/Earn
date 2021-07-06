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
        $services = InvoiceServiceToken::all();
        return view('livewire.teams.manage-team-invoice-api', [
            'services' => $services
        ]);
    }

    public function signout()
    {
        //Reaches here when no params are passed, following livewire guide (https://laravel-livewire.com/docs/2.x/actions#action-parameters)

        return redirect('/testing');
        // $deleteQuery = InvoiceServiceToken::where(['name' => $service, 'team_id' => $this->team->id])
        //     ->first()
        //     ->delete();
            
    }
}
