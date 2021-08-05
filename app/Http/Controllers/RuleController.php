<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rule;


class RuleController extends Controller
{
    function insertRule(Request $req){

        request()->validate([
            'new_rule_name' => ['required', 'max:15'],
            'new_start_date' => ['required','date','after_or_equal:today'],
            'new_end_date' => ['required','date', 'after:start_date'],
            'new_percentage' => ['required','numeric','gt:0', 'lte:999'],
        ]);

        $rule = new Rule;
        //Setting fields to go into the rule table
        $rule->team_id = auth()->user()->currentTeam->id;  
        $rule->rule_name=$req->new_rule_name;
        //Rule is default active until changed by manager
        $rule->active=true;
        $rule->start_date=$req->new_start_date;
        $rule->end_date=$req->new_end_date;
        $rule->percentage=$req->new_percentage;

        $rule->save();
               
        return redirect('rules');
    }



    function editForm(Request $req){

        

        request()->validate([
            'rule_name' => ['required', 'max:15'],
            'start_date' => ['required','date','after_or_equal:today'],
            'end_date' => ['required','date', 'after_or_equal:start_date'],
            'percentage' => ['required','numeric','gt:0', 'lte:999'],

        ]);

        // Update or Delete depending on what button was pressed in the form
        switch($req->submitButton){

            case "Update":

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
            break;
            
            case "Remove": 
                $rule = Rule::find($req->id);     
                if($rule){     
                    $rule->delete();
                }
        
            return redirect('rules');
            break;
        }
        

    }

    
}
