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
        //Need to get a rolling 6 months History & Predictions for the graph 

        $currentMonth = Carbon::now($this->user->timezone)->format('n');
        $currentYear = Carbon::now($this->user->timezone)->format('Y');


        //History Data
        $historic = array(0,0,0,0,0,0,0,0,0,0,0,0);
        foreach(History::all()->where('team_user_id', $this->user->id) as $history) {
            //Adds up all of the commision by month
            $historic[Carbon::parse($history->end_time)->format('n') -1] += $history->total_commission;
       
        };
       
        //Predictions Data
        $prediction = app('App\Http\Controllers\PredictionController')->predict($this->user->id, 6);
        
        //Months
        $months = ['Jan', 'Feb', 'Mar', 'Apr','May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov','Dec'];
        
       

        return view('livewire.employees.graph', [
            'historic' => $historic,
            'prediction' => $prediction,
            'months' => $months,
        ]);
        
    }
}
