<?php

namespace App\Http\Controllers;

use App\Classes\Invoice;
use App\Models\TeamUser;
use App\Models\User;
use App\Models\History;
use App\Models\Sales;
use XeroPHP\Models\Accounting\LineItem;
use App\Classes\InvoiceGenerator;
use Carbon\Carbon;

class ParsingController extends Controller
{
    //What is this?
    //protected $gen = new InvoiceGenerator;

    public static function parseLineItem(LineItem $item, $api_team_origin = 1)
    {
        /*
        Parses the Xero LineItem and SMC's descriptions into Invoice objects
        */
        // api_team_origin should be assigned to the respective team_id when we GET from Xero
        // {Service} with {Employee} at {Location} on {Date and Time}
        $desc = $item->getDescription();
        if (is_null($desc)) {
            return response('Bad Request: No description found', 400);
        }
        $amount = $item->getUnitAmount();
        if (is_null($amount)) {
            return response('Bad Request: No unit amount found', 400);
        }

        $pattern = "/(.+) with (.+) at (.+) on (.+)/"; 
        $result = preg_match_all($pattern, $desc,$matches);
        if ($result == 0) {
            return response('Invalid Format: Line item did not match the required format',400);
        }
        $names = explode(" ",$matches[2][0]);
        $f_name = $names[0];
        $l_name = $names[1];
        $c_user_id = User::all()->where('first_name','=',$f_name)->firstWhere('last_name','=',$l_name)->id;
        $team_user = TeamUser::all()->where('user_id','=',$c_user_id)->firstWhere('team_id','=',$api_team_origin);
        return new Invoice($team_user,$matches[1][0],$amount,new Carbon($matches[4][0]));
    }

    public static function saveInvoice(Invoice $invoice) {
        /*
        Saves an invoice object into the history and sales table.
        */
        $p_his = History::all()->where('team_user_id','=',$invoice->team_user->id)
            ->firstWhere('end_time','>',now());
        if (is_null($p_his)) {
            $p_his = History::factory()->create([
                'team_user_id' => $invoice->team_user->id,
                'start_time' => $invoice->date->startOfMonth(),
                'end_time' => $invoice->date->endOfMonth(),
                'total_commission' => $invoice->service_cost*0.1
            ]);
        } else {
            $p_his->total_commission += $invoice->service_cost*0.1;
            $p_his->save();
        }
        Sales::create([
            'team_user_id' => $invoice->team_user->id,
            'service_name' => $invoice->service_name,
            'service_cost' => $invoice->service_cost,
            'commission_earned' => $invoice->service_cost*0.1
        ]);
    }

    public static function fetchInvoices() {
        /*
        Check for any new invoices from API
        */
        
    }
}
