<?php

namespace App\Classes;

use App\Models\TeamUser;
use App\Models\Sale;
use App\Models\User;
use App\Models\Team;
use Carbon\Carbon;

class Invoice {
    /*
    Invoice class to be constructed by your API parser.
    Instances of this class are then used to populate the
    history and sales tables.
    */ 
    public $team;
    public $user;
    public $team_user;
    public $service_name;
    public $service_cost;
    public Carbon $date;

    function __construct(User $user, Team $team, $name, $cost, Carbon $date=null)
    {
        $this->user = $user;
        $this->team = $team;
        $this->team_user = TeamUser::where('user_id',$user->id)->firstWhere('team_id',$team->id);
        $this->service_name = $name;
        $this->service_cost = $cost;
        if (is_null($date)) {
            $this->date = now('Australia/Brisbane');
        } else {
            $this->date = $date;
        }
            
        return;
    }

    function asSale() {
        return new Sale([
            'team_user_id' => $this->team_user->id,
            'service_name' => $this->service_name,
            'service_cost' => $this->service_cost,
            'commission_paid' => $this->service_cost*0.1,
            'date' => $this->date
        ]);
    }
}