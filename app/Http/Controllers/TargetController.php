<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;
use Symfony\Component\VarDumper\VarDumper;

class TargetController extends Controller
{
    function updateTarget(Request $req){
        request()->validate([
            'new_target' => ['required', 'max:15']
        ]);
         $team = Team::find($req->team);
         if($team != null){
            $team->target_commission = $req->new_target;
            $team->save();
         }
        //Sends back to the same page
        $source = request()->headers->get('referer');
        return(redirect($source));
    }

}