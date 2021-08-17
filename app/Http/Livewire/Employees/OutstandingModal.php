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
        back();
    }

    public function flag($id)
    {
        $com = new TeamCommission;
        $com->flagCommission($id);
        back();
    }

    public function render()
    {

        $teamUser = TeamUser::where('team_id', $this->user->currentTeam->id)->where('user_id', $this->user->id)->first();
        $comOustanding = History::where('team_user_id', $teamUser->id)
            ->where('flagged', 0)
            ->where('approved', 0)
            ->get();

        if ($comOustanding != null) {
            $res = null;
            foreach ($comOustanding as $x) {
                if (Carbon::parse($x->start_time)->format('m.y') != Carbon::today()->format('m.y')) {
                    $res = $x;
                    break;
                }
            }
        }
        if ($res != null) {
            return view('livewire.employees.outstanding-modal', [
                'id' => $res->id,
                'total' => $res->total_commission,
                'start_time' => Carbon::parse($res->start_time)->toFormattedDateString(),
                'end_time' => Carbon::parse($res->end_time)->toFormattedDateString(),
            ]);
        }
        return ("<div></div>");
    }
}
