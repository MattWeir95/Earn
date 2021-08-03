<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rule;


class NewRuleController extends Controller
{
    function insertRule(Request $req){


        $rule = new Rule;

        //Setting fields to go into the rule table
        $rule->team_id = auth()->user()->currentTeam->id;
        $rule->rule_name=$req->rule_name;
        //Rule is default active until changed by manager
        $rule->active=true;
        $rule->start_date=$req->start_date;
        $rule->end_date=$req->end_date;
        $rule->percentage=$req->percentage;


        $rule->save();
        
        
        return redirect('ruleScreen');
    }
}
