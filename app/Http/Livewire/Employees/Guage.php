<?php

namespace App\Http\Livewire\Employees;

use Livewire\Component;
use App\Models\History;
use App\Models\TeamUser;
use Carbon\Carbon;

class Guage extends Component
{
    /**
     * The user instance.
     *
     * @var mixed
     */
    public $user;

    /**
     * Mount the component.
     *
     * @param  mixed  $user
     * @return void
     */
    public function mount($user)
    {
        $this->user = $user;
    }

   

    public function render()
    {   
        $team = $this->user->currentTeam;

        //Current Sales
        $team_user = TeamUser::where('user_id', $this->user->id)->where('team_id', $this->user->currentTeam->id)->first();
        $currentSales = History::where('team_user_id', $team_user->id)->where('end_time', now('AEST')->endOfMonth())->first();
        $previousSales = History::where('team_user_id', $team_user->id)->where('end_time', now('AEST')->endofMonth()->subMonth())->first();

        if($previousSales != null){
            $previousSales = $previousSales->total_commission;
        } else {
            $previousSales = 200;
        }
        return view('livewire.employees.guage', [
            'currentSales' => $currentSales->total_commission,
            'periodEndDate' => Carbon::parse($currentSales->end_time)->toFormattedDateString(),
            'previousSales' => $previousSales 
        ]);
    }
}
