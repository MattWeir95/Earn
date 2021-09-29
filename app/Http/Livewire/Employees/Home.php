<?php

namespace App\Http\Livewire\Employees;

use App\Actions\CommissionApproval\TeamCommission;
use Livewire\Component;

class Home extends Component
{
    public function render()
    {
        return view('livewire.employees.home');
    }
}
