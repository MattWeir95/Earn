<?php

namespace App\Http\Livewire\Teams;

use Livewire\Component;

class ManageTeamTarget extends Component
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
        return view('livewire.teams.manage-team-target');
    }
}
