<?php

namespace App\Http\Livewire\Managers\Dashboard;

use App\Models\History;
use App\Models\TeamUser;
use App\Models\User;
use Livewire\Component;

class EmployeeList extends Component
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

        $employeeList = array();
        $employees = TeamUser::where('team_id', $this->user->currentTeam->id)->where('role', 'employee')->get();

        if($employees != null){
            foreach($employees as $employee)
            {
                 $employeeName = User::where('id', $employee->user_id)->first();
                 $employeeName = $employeeName->first_name . " " . $employeeName->last_name;

                 $history = History::where('team_user_id', $employee->id)->firstWhere('end_time', now('AEST')->endOfMonth());
                 $history = $history->total_commission;
                 $history != null
                     ? array_push($employeeList, ['name' => $employeeName, 'currentSales' => $history, 'target' => $this->user->currentTeam->target_commission]) 
                     : array_push($employeeList, ['name' => $employeeName, 'currentSales' => 0, 'target' => $this->user->currentTeam->target_commission]);
            }                
        }
    
        return view('livewire.managers.dashboard.employee-list', [
            'employees' => json_encode($employeeList) 
        ]);
    }
}
