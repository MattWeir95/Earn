<?php

namespace App\Http\Livewire\Employees;

use Livewire\Component;
use App\Models\Team;
use Carbon\Carbon;
use App\Models\History;
use App\Models\TeamUser;
use App\Http\Controllers\PredictionController;



class Graph extends Component
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
        $team_user = TeamUser::where('user_id', $this->user->id)->where('team_id', $this->user->currentTeam->id)->first();

        $numberOfHistories = 3;
        //Retrive n ($numberOfHistories) number of historyies into the past.
        $histories = History::where('team_user_id','=',$team_user->id)->orderBy('start_time','desc')->take($numberOfHistories)->get();

        $totalCommission = [];
        //Fills the total commission array with the total commission earned for each month. 
        for($x = 0; $x < count($histories) ; $x ++){
            $totalCommission[$x] = $histories[$x]->total_commission;
        }

        //reverses order of the array to have it from past to future
        $totalCommission = array_reverse($totalCommission);

        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May','Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $monthsForGraph = [];
        $currentMonth = Carbon::now($this->user->timezone)->format('n');
        $monthCount = $currentMonth -$numberOfHistories;
        $count = 0;

        //Fills the $monthForGraph array with the amount of months of history and always 2 extra for the predictions
        while($count < $numberOfHistories +2){

            //Catches overflow and resets it back to 'Jan'
            if($monthCount > 11){
                $monthCount = 0;
            }
            $monthsForGraph[$count] = $months[$monthCount];
            
            $monthCount++;
            $count++;
        }
        
        $monthsOfPredictionInFuture = 2;
        //Returns an array of the predictions for the next n months
        $predictions = app('App\Http\Controllers\PredictionController')->predict($team_user->id, count($histories) + $monthsOfPredictionInFuture);
    
    
        return view('livewire.employees.graph', [
            'historic' => $totalCommission,
            'prediction' => $predictions,
            'months' => $monthsForGraph,
        ]);


       
        
    }
}
