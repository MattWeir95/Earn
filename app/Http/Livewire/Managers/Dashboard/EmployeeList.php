<?php

namespace App\Http\Livewire\Managers\Dashboard;

use App\Models\History;
use App\Models\TeamUser;
use App\Models\User;
use Livewire\Component;

class EmployeeList extends Component
{

    public $selectedEmployee;
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
        $employeeList = array(); 
        $employees = $this->user->currentTeam->employees()->get();

        if($employees != null){
            foreach($employees as $employee)
            {
                 $history = $employee->currentHistory($this->user->currentTeam);
                 $history != null
                     ? array_push($employeeList, ['name' => $employee->fullName(), 'currentSales' => $history->total_commission, 'target' => $this->user->currentTeam->target_commission, 'id' => $employee->id]) 
                     : array_push($employeeList, ['name' => $employee->fullName(), 'currentSales' => 0, 'target' => $this->user->currentTeam->target_commission,'id' => $employee->id]);
            }                
        }
    
        return view('livewire.managers.dashboard.employee-list', [
            'employees' => json_encode($employeeList) 
        ]);
    }
}
