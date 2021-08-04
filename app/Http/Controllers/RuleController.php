<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rule;


class RuleController extends Controller
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
               
        return redirect('rules');
    }

    function updateRule(Request $req){
        $rule = Rule::find($req->id);

        if($rule){

            // Active was coming in as "on" or Null so converting it into a bool
            $active = false;
            if($req->active == "on"){
                $active = true;
            }

            $rule->rule_name= $req->rule_name;
            $rule->start_date= $req->start_date; 
            $rule->end_date= $req->end_date; 
            $rule->percentage= $req->percentage;
            $rule->active= $active;

            $rule->save();
            }

            return redirect('rules');

            
    }
}
