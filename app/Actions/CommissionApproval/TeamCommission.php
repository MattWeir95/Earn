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
        $employees = TeamUser::where('team_id', $user->currentTeam->id)->where('role', 'employee')->get();

        if ($employees != null) {
            foreach ($employees as $employee) {
                $employeeName = User::where('id', $employee->user_id)->first();
                $employeeName = $employeeName->first_name . " " . $employeeName->last_name;

                $history = History::where('team_user_id', $employee->id)->where('end_time', '<', now('AEST')->startOfMonth())->where('approved', 0)->where('flagged', 0)->get();

                //Multiple outstanding commissions
                if ($history != null) {
                    foreach ($history as $x) {
                        array_push($commissionApprovals, [
                            'id' => $x->id,
                            'name' => $employeeName,
                            'totalCommission' => $x->total_commission,
                            'start_time' => Carbon::parse($x->start_time)->toFormattedDateString(),
                            'end_time' => Carbon::parse($x->end_time)->toFormattedDateString()
                        ]);
                    }
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
