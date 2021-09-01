<?php

namespace App\Http\Livewire\Managers\Dashboard;

use App\Models\User;
use Livewire\Component;

class EmployeeModal extends Component
{
    public $selected_user;

    public function mount($user_id)
    {
        $this->selected_user = User::where('id', $user_id)->first();
    }

    public function render()
    {
        return view('livewire.managers.dashboard.employee-modal', [
            'user' => $this->selected_user
        ]);
    }
}
