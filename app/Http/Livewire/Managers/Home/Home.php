<?php

namespace App\Http\Livewire\Managers\Home;

use App\Models\InvoiceService;
use Livewire\Component;
use App\Models\InvoiceServiceToken;
use LangleyFoxall\XeroLaravel\XeroApp;
use League\OAuth2\Client\Token\AccessToken;

class Home extends Component
{
    // /**
    //  * The team instance.
    //  *
    //  * @var mixed
    //  */
    // public $team;

    // /**
    //  * Mount the component.
    //  *
    //  * @param  mixed  $team
    //  * @return void
    //  */

    // public function mount($team)
    // {
    //     $this->team = $team;
    // }

    public function render()
    {
        return view('livewire.managers.home.home');
    }

}
