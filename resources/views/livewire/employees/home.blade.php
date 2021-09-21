<div class="max-w-7xl mx-auto sm:px-6 lg:px-8" >

<widget-container class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:p-12 pt-12">
        @livewire('employees.gauge', ['user' => Auth::user(),'team' => Auth::user()->currentTeam])
        @livewire('employees.graph', ['user' => Auth::user(),'team' => Auth::user()->currentTeam])
</widget-container>
<div>       
        @livewire('employees.outstanding-modal', ['user' => Auth::user()]);
</div>

