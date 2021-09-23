<?php

namespace App\Http\Livewire\Managers\Rules;

use Livewire\Component;
use App\Models\Rule;


class EditRules extends Component
{
    public $rule_name;
    public $start_date;
    public $end_date;
    public $percentage;
    public $rule_id;
    public $message;
    /**
     * The team instance.
     *
     * @var mixed
     */
    public $team;

    /**
     * Mount the component.
     *
     * @param  mixed  $team
     * @return void
     */
    public function mount($team)
    {
        $this->team = $team;
    }

    public function editRule(){

        // Checking that event has been passed from the rule list, If it has and one of the values havnt been changed but have been
        //sent from the event it sets it to that instead.
        if($this->message){
            if(!$this->rule_name){
                $this->rule_name = $this->message['rule_name'];
            }
            if(!$this->start_date){
                $this->start_date = $this->message['start_date'];
            }
            if(!$this->end_date){
                $this->end_date = $this->message['end_date'];
            }
            if(!$this->percentage){
                $this->percentage = $this->message['percentage'];
            } 
            if(!$this->rule_id){
                $this->rule_id = $this->message['id'];
            }
        }

    
        $validated = $this->validate([
                    'rule_name' => ['required', 'max:15'],
                    'start_date' => ['required','date'],
                    'end_date' => ['required','date', 'after_or_equal:start_date'],
                    'percentage' => ['required','numeric','gt:0', 'lte:999'],
                    'rule_id' => ['required'],
                ]);


        if(($validated)){

            $rule = Rule::find($this->rule_id);
            $rule->rule_name=$this->rule_name;
            $rule->start_date=$this->start_date; 
            $rule->end_date=$this->end_date; 
            $rule->percentage=$this->percentage;
            $rule->active=$rule->active;

            $rule->save();
        }
        return redirect('rules');
    }

    public function deleteRule(){

        if($this->message){
            if(!$this->rule_id){
                $this->rule_id = $this->message['id'];
            }
        }

        $rule = Rule::find($this->rule_id);  
        if($rule){     
            $rule->delete();
        }

        return redirect('rules');
    }

    public function render()
    {
        return view('livewire.managers.rules.edit-rules', [
            'rules' => $this->team->rules()->get()
        ]);
    }
}
