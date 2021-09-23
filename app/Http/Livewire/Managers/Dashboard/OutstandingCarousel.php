<?php

namespace App\Http\Livewire\Managers\Dashboard;

use Livewire\Component;
use App\Actions\CommissionApproval\TeamCommission;

class OutstandingCarousel extends Component
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

    public function approve($id)
    {
        $remainingCommissions = new TeamCommission;
        $remainingCommissions->approveCommission($id);
        $remainingCommissions = $remainingCommissions->getTeamCommission($this->user);

        if (count($remainingCommissions) > 0) {
            back();
        } else {
            return redirect("dashboard");
        }
    }

    public function flag($id)
    {
        $remainingCommissions = new TeamCommission;
        $remainingCommissions->flagCommission($id);
        $remainingCommissions = $remainingCommissions->getTeamCommission($this->user);

        if (count($remainingCommissions) > 0) {
            back();
        } else {
            return redirect("dashboard");
        }
    }

    public function render()
    {
        $commissionApprovals = new TeamCommission;
        $commissionApprovals = $commissionApprovals->getTeamCommission($this->user);
        $total = count($commissionApprovals);
        return view('livewire.managers.dashboard.outstanding-carousel', [
            'commissionApprovals' => json_encode($commissionApprovals),
            'total' => $total
        ]);
    }
}
