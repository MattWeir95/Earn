<?php

namespace App\Classes;

use App\Models\TeamUser;
use App\Models\Sales;
use Carbon\Carbon;

class Invoice {
    /*
    Invoice class to be constructed by your API parser.
    Instances of this class are then used to populate the
    history and sales tables.
    */ 
    public $team_user;
    public $service_name;
    public $service_cost;
    public Carbon $date;

    function __construct(TeamUser $team_user, $name, $cost, Carbon $date=null)
    {
        $this->team_user = $team_user;
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
        return new Sales([
            'team_user_id' => $this->team_user->id,
            'service_name' => $this->service_name,
            'service_cost' => $this->service_cost,
            'commission_paid' => $this->service_cost*0.1,
            'date' => $this->date
        ]);
    }
}