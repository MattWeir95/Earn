<?php

namespace App\Http\Livewire\Managers\Dashboard;

use App\Models\User;
use App\Models\Team;
use Livewire\Component;

class EmployeeModal extends Component
{
    public $selected_user;
    public $team;

    public function mount($user_id, Team $team)
    {
        $this->selected_user = User::find($user_id);
        $this->team = $team;
    }

    public function render()
    {
        return view('livewire.managers.dashboard.employee-modal', [
            'user' => $this->selected_user,
            'team' => $this->team
        ]);
    }
}
