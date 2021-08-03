<?php

namespace App\Http\Livewire\Managers\Rules;

use Livewire\Component;
use App\Models\Rule;


class ViewRulesList extends Component
{

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

    public function render()
    {
        $rules = Rule::where('team_id', $this->team->id)->get();


        return view('livewire.managers.rules.view-rules-list', [
            'rules' => $rules
        ]);
    }
}
