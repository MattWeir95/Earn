<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rule;
use App\Classes\Invoice;
use Carbon\Carbon;

class RuleController extends Controller
{

    public static function getCommission(Invoice $invoice) {
        $rule = Rule::where('team_id','=',$invoice->team_user->team_id)
                    ->where('active','=', 1)
                    //Commented out while dates are being changed over to carbon
                    ->where('start_date','<=',Carbon::parse($invoice->date)->format('y.m.d')) 
                    ->where('end_date','>=',Carbon::parse($invoice->date)->format('y.m.d'))
                    ->orderBy('percentage', 'DESC')
                    ->first();
        if (is_null($rule)) { return 0; }
        return $invoice->service_cost*($rule->percentage/100);
    }

    
}
