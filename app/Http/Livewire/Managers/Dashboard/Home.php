<?php

namespace App\Http\Livewire\Managers\Dashboard;

use App\Actions\CommissionApproval\TeamCommission;
use App\Models\TeamUser;
use Livewire\Component;

class Home extends Component
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
        $employees = $this->user->currentTeam->employees()->get()->count();
        
        if ($employees) {
            $outstandingCommissions = new TeamCommission;
            $outstandingCommissions = $outstandingCommissions->getTeamCommission($this->user);
            $total = count($outstandingCommissions);
            return view('livewire.managers.dashboard.home', [
                'total' => $total
            ]);
        }
        
        return view('livewire.managers.dashboard.default-home');
    }
}
