<?php

namespace App\Http\Livewire\Employees;

use Livewire\Component;
use App\Models\History;
use App\Models\TeamUser;

class Guage extends Component
{
    /**
     * The user instance.
     *
     * @var mixed
     */
    public $user;

    /**
     * Mount the component.
     *
     * @param  mixed  $user
     * @return void
     */
    public function mount($user)
    {
        $this->user = $user;
    }
    

    public function render()
    {
        return view('livewire.employees.guage');
    }
}
