<?php

namespace App\Http\Livewire\Employees;

use App\Actions\CommissionApproval\TeamCommission;
use App\Models\History;
use App\Models\TeamUser;
use Carbon\Carbon;
use Livewire\Component;

class OutstandingModal extends Component
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

    //Approval Function used for single approval
    public function approve($id)
    {
        $com = new TeamCommission;
        $com->approveCommission($id);
    }

    //Flag Function used for single approval
    public function flag($id)
    {
        $com = new TeamCommission;
        $com->flagCommission($id);
    }

    public function render()
    {
        $comOustanding = $this->user->historiesForTeam($this->user->currentTeam)
            ->where('flagged', 0)
            ->where('approved', 0)
            ->orderBy('end_time', 'asc')
            ->first();

        $dueApproval = array();
        if ($comOustanding != null) {
            if (Carbon::parse($comOustanding->start_time)->format('m.y') != Carbon::today()->format('m.y') && $comOustanding->total_commission > 0) {
                array_push($dueApproval, [
                    'id' => $comOustanding->id,
                    'total' => $comOustanding->total_commission,
                    'start_time' => Carbon::parse($comOustanding->start_time)->toFormattedDateString(),
                    'end_time' => Carbon::parse($comOustanding->end_time)->toFormattedDateString()
                ]);

                return view('livewire.employees.outstanding-modal', [
                    'approval' => $dueApproval
                ]);
            }
        }
        return ('<div id="no-approvals"></div>');
    }
}
