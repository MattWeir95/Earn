<?php

namespace App\Http\Livewire\Employees;

use Livewire\Component;
use App\Models\Team;
use Carbon\Carbon;
use App\Models\History;
use App\Models\TeamUser;



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
        
        //Graph Data
        $historic = [100,80,20,80];
        $prediction = [110,85,70,50,90];
        $months = ['Jan', 'Feb', 'Apr', 'Jun','Jul'];


      
        return view('livewire.employees.graph', [
            'historic' => $historic,
            'prediction' => $prediction,
            'months' => $months,
        ]);
        
    }
}
