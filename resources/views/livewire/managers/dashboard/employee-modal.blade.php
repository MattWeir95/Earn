<div class="p-4 bg-white rounded-lg shadow-lg">
    @livewire('employees.gauge', ['user' => $user, 'teamId' => Auth::user()->currentTeam->id])
    <div class="pt-2"></div>
    @livewire('employees.graph', ['user' => $user, 'teamId' => Auth::user()->currentTeam->id])
</div>
