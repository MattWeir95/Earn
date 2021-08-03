<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ViewRuleController extends Controller
{
    function render(){
        return $rules = Rule::where('team_id', $this->team->id)->get();
    }
}
