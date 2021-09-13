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

    public function approve($id)
    {
        $com = new TeamCommission;
        $com->approveCommission($id);
    }

    public function flag($id)
    {
        $com = new TeamCommission;
        $com->flagCommission($id);
    }

    public function render()
    {
        $teamUser = TeamUser::where('team_id', $this->user->currentTeam->id)->where('user_id', $this->user->id)->first();
        $comOustanding = $this->user->historiesForTeam($this->user->currentTeam)
            ->where('flagged', 0)
            ->where('approved', 0)
            ->get();


        if ($comOustanding != null) {
            $dueApproval = array();
            foreach ($comOustanding as $x) {
                if (Carbon::parse($x->start_time)->format('m.y') != Carbon::today()->format('m.y') && $x->total_commission > 0) {
                    array_push($dueApproval, [
                        'id' => $x->id,
                        'total' => $x->total_commission,
                        'start_time' => Carbon::parse($x->start_time)->toFormattedDateString(),
                        'end_time' => Carbon::parse($x->end_time)->toFormattedDateString(),
                    ]);
                }
            }
        }
        if (count($dueApproval) > 0) {
            return view('livewire.employees.outstanding-modal', [
                'dueApproval' => $dueApproval
            ]);  
        }
        return ("<div></div>");
    }
}
