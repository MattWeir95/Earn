<?php

namespace App\Classes;

use App\Models\TeamUser;
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
            $this->date = now();
        } else {
            $this->date = $date;
        }
            
        return;
    }
}