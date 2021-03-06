<?php

namespace App\Http\Controllers;

use App\Classes\Invoice;
use App\Models\TeamUser;
use App\Models\Team;
use App\Models\User;
use App\Models\History;
use App\Models\Sale;
use App\Models\InvoiceServiceToken;
use XeroPHP\Models\Accounting\LineItem;
use App\Classes\InvoiceGenerator;
use App\Classes\MockFetcher;
use Carbon\Carbon;
use App\Http\Controllers\RuleController;

class ParsingController extends Controller
{
    public static function parseLineItem(LineItem $item, Team $team)
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

        $pattern = "/(.+) with (.+) at (.+) on (.+)$/"; 
        $result = preg_match_all($pattern,$desc,$matches);
        if ($result == 0) {
            return response('Invalid Format: Line item did not match the required format',400);
        }
        $names = explode(" ",$matches[2][0]);
        $user = $team->users()->where('last_name',$names[1])->firstWhere('first_name',$names[0]);
        return new Invoice($user,$team,$matches[1][0],$amount,new Carbon($matches[4][0]));
    }

    public static function saveInvoice(Invoice $invoice) {
        /*
        Saves an invoice object into the history and sales table.
        */
        $commission_paid = RuleController::getCommission($invoice);
        Sale::create([
            'team_user_id' => $invoice->team_user->id,
            'service_name' => $invoice->service_name,
            'service_cost' => $invoice->service_cost,
            'commission_paid' => $commission_paid,
            'date' => $invoice->date
        ]);
        $p_his = $invoice->team_user->currentHistory();
        if (is_null($p_his)) {
            $p_his = History::factory()->create([
                'team_user_id' => $invoice->team_user->id,
                'start_time' => $invoice->date->copy()->startOfMonth(),
                'end_time' => $invoice->date->copy()->endOfMonth(),
                'total_commission' => $commission_paid
            ]);
        } else {
            $p_his->total_commission += $commission_paid;
            $p_his->save();
        }
    }

    public static function updateInvoices() {
        /*
        Check for any new invoices from API
        */
        $fetchers = [
            'Xero' => new MockFetcher,
            'some_other_endpoint' => 'some_other_fetcher'
        ];
        $gen = new InvoiceGenerator;
        foreach (Team::all() as $team) {
            $token = $team->invoiceServiceToken();
            if (is_null($token)) {
                $token = InvoiceServiceToken::factory()->create(['team_id'=>$team->id]);
                // continue;
            }
            // This should return the most recent invoice from xero,
            // also should be calling some annonymous API controller,
            // not xero explicitly
            // $item = ParsingController::parseLineItem(XeroController::fetchInvoice($token));
            // $item = ParsingController::parseLineItem($gen->getXeroLineItem(),$team->id);  
            $items = $fetchers[$token->app_name]->fetchInvoices($token->access_token);
            foreach ($items as $item) {
                ParsingController::saveInvoice($item);
            }
        }
    }
}
