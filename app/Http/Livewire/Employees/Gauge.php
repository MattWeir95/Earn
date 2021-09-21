<?php

namespace App\Http\Livewire\Employees;

use Livewire\Component;
use App\Models\History;
use App\Models\TeamUser;
use App\Models\Team;
use App\Models\User;
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
    public $team;

    /**
     * Mount the component.
     *
     * @param  mixed  $user
     * @return void
     */
    public function mount(User $user, Team $team)
    {
        $this->user = $user;
        $this->team = $team;
    }

   

    public function render()
    {   
        $currentSales = $this->user->currentHistory($this->team);
        if($currentSales != null){
            return view('livewire.employees.gauge', [
                'currentSales' => $currentSales->total_commission,
                'periodEndDate' => Carbon::parse($currentSales->end_time)->toFormattedDateString(),
                'target' => $this->team->target_commission 
            ]);
        }

        return view('livewire.employees.gauge', [
            'currentSales' => 0,
            'periodEndDate' => 'No Sales Found',
            'target' => $this->team->target_commission
        ]);
    }
}
