<?php

namespace App\Http\Livewire\Employees;

use Livewire\Component;
use App\Models\History;
use App\Models\TeamUser;
use App\Models\Team;
use Carbon\Carbon;

class Gauge extends Component
{
    /**
     * The user instance.
     *
     * @var mixed
     */
    public $user;

    /**
     * Determine team based on employee or manager view.
     *
     * @var mixed
     */
    public $teamId;

    /**
     * Mount the component.
     *
     * @param  mixed  $user
     * @return void
     */
    public function mount($user, $teamId)
    {
        $this->user = $user;
        $this->teamId = $teamId;
    }

   

    public function render()
    {   
        //Current Sales
        //Determines whether the request is coming from a logged in employee or from the manager view of all employees
        $team_user = ($this->teamId == null ?  TeamUser::where('user_id', $this->user->id)->where('team_id', $this->user->currentTeam->id)->first() 
        : TeamUser::where('user_id', $this->user->id)->where('team_id', $this->teamId)->first());
                        
        $currentSales = History::where('team_user_id', $team_user->id)->firstWhere('end_time', now('AEST')->endOfMonth());
        $target = Team::where('id', $team_user->team_id)->first();
        if($currentSales != null){
            return view('livewire.employees.gauge', [
                'currentSales' => $currentSales->total_commission,
                'periodEndDate' => Carbon::parse($currentSales->end_time)->toFormattedDateString(),
                'target' => $target->target_commission 
            ]);
        }

        return view('livewire.employees.gauge', [
            'currentSales' => 0,
            'periodEndDate' => 'No Sales Found',
            'target' => $target->target_commission
        ]);
    }
}
