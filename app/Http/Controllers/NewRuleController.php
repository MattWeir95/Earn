<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rule;


class NewRuleController extends Controller
{
    function insertRule(Request $req){


        $rule = new Rule;

        //Setting fields
        $rule->team_id = auth()->user()->currentTeam->id;
        $rule->rule_name=$req->rule_name;

        //Rule is default inactive until set active by manager
        $rule->active=false;

        
        $rule->start_date=$req->start_date;
        $rule->end_date=$req->end_date;
        $rule->percentage=$req->percentage;


        $rule->save();

        //Have it returning to the view for testing purposes.
        return redirect('newRuleModal');
    }
}
