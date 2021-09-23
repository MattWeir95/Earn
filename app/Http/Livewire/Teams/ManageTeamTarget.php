<?php

namespace App\Http\Livewire\Teams;

use Illuminate\Auth\Events\Validated;
use Livewire\Component;

class ManageTeamTarget extends Component
{
    /**
     * The team instance.
     *
     * @var mixed
     */
    public $team;

    public $target;
    /**
     * Mount the component.
     *
     * @param  mixed  $team
     * @return void
     */
    public function mount($team, $target = null)
    {
        $this->team = $team;
        if ($target == null) { 
            $this->target = $team->target_commission;
        } else {
            $this->target = $target;
        }
    }

    function updateTarget()
    {
        $validated = $this->validate([
            'target' => ['required', 'max:4', 'gt:0', 'lte:1000']
        ]);
        if (($validated)) {

            if ($this->team != null) {
                $this->team->target_commission = $this->target;
                $this->team->save();
            }
        }
        back();
    }
    public function render()
    {
        return view('livewire.teams.manage-team-target');
    }
}
