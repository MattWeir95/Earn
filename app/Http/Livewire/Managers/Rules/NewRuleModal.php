<?php

namespace App\Http\Livewire\Managers\Rules;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Rule;

class NewRuleModal extends Component
{
    public $rule_name;
    public $start_date;
    public $end_date;
    public $percentage;

    public function insertRule(){

        $validated = $this->validate([
                    'rule_name' => ['required', 'max:15'],
                    'start_date' => ['required','date'],
                    'end_date' => ['required','date', 'after_or_equal:start_date'],
                    'percentage' => ['required','numeric','gt:0', 'lte:999'],
                ]);

            if($validated){
                    DB::table('rules')
                    ->insert([
                    'team_id' => auth()->user()->currentTeam->id,
                    'rule_name' => $this->rule_name,
                    'start_date' => $this->start_date,
                    'end_date' => $this->end_date,
                    'active' => 1,
                    'percentage' => $this->percentage,
                ]);
            }
        return redirect('rules');
    }

    public static function insert_without_check($name, $start, $end, $percentage) {
        DB::table('rules')
        ->insert([
            'team_id' => auth()->user()->currentTeam->id,
            'rule_name' => $name,
            'start_date' => $start,
            'end_date' => $end,
            'active' => 1,
            'percentage' => $percentage,
        ]);
    }
     
    public function render()
    {
        return view('livewire.managers.rules.new-rule-modal');
    }
}
