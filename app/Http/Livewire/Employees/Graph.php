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

        $numberOfHistories = 5;
        $totalCommission = [];
        $months = [];

        $histories = History::where('team_user_id','=',$team_user->id)->orderBy('start_time','desc')->take($numberOfHistories)->get();

        //Fills the total commission array with the total commission earned for each month, 
        //and the month array with the string format of the month for the graph.
        for($x = 0; $x < count($histories) ; $x ++){
            $totalCommission[$x] = $histories[$x]->total_commission;
            $months[$x] = Carbon::parse($histories[$x]->end_time)->format('M');
        }

        //Returns an array of the predictions for the next n months if not return an empty array
        if($totalCommission && $histories){
        $predictions = app('App\Http\Controllers\PredictionController')->predict($team_user->id, count($histories));
        }else{
            $predictions = [];
        }
        
        

        
        
    
    

        return view('livewire.employees.graph', [
            'historic' => $totalCommission,
            'prediction' => $predictions,
            'months' => $months,
        ]);


       
        
    }
}
