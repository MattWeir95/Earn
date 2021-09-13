<?php

namespace App\Actions\CommissionApproval;

use App\Models\History;
use App\Models\TeamUser;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TeamCommission
{

    public function getTeamCommission($user)
    {
        $commissionApprovals = array();
        $employees = $user->currentTeam->users()->get();
        foreach ($employees as $employee) {

            $history = $employee->historiesForTeam($user->currentTeam)->where('end_time', '<', now('AEST')->startOfMonth())->where('approved', 0)->where('flagged', 0)->get();
            
            //Multiple outstanding commissions
            if ($history != null) {
                foreach ($history as $x) {
                    array_push($commissionApprovals, [
                        'id' => $x->id,
                        'name' => $employee->fullName(),
                        'totalCommission' => $x->total_commission,
                        'start_time' => Carbon::parse($x->start_time)->toFormattedDateString(),
                        'end_time' => Carbon::parse($x->end_time)->toFormattedDateString()
                    ]);
                }
            }
        }
        return $commissionApprovals;
    }

    public function approveCommission($id)
    {
        DB::table('history')
            ->where('id', $id)
            ->update(['approved' => 1]);
    }

    public function flagCommission($id)
    {
        DB::table('history')
            ->where('id', $id)
            ->update(['flagged' => 1]);
    }
}
