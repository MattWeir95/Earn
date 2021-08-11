<?php

namespace App\Http\Livewire\Employees;

use Livewire\Component;
use App\Models\History;
use App\Models\TeamUser;
use App\Models\Team;
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
        $currentSales = History::where('team_user_id', $team_user->id)->firstWhere('end_time', now('AEST')->endOfMonth());
        $target = Team::where('id', $team_user->team_id)->first();
        if($currentSales != null){
            return view('livewire.employees.guage', [
                'currentSales' => $currentSales->total_commission,
                'periodEndDate' => Carbon::parse($currentSales->end_time)->toFormattedDateString(),
                'target' => $target->target_commission 
            ]);
        }

        return view('livewire.employees.guage', [
            'currentSales' => 0,
            'periodEndDate' => 'No Sales Found',
            'target' => $target->target_commission
        ]);
    }
}
