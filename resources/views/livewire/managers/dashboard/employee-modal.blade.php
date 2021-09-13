<div class="p-4 bg-white rounded-lg shadow-lg">
    @livewire('employees.gauge', ['user' => $user, 'team' => Auth::user()->currentTeam])
    <div class="pt-2"></div>
    @livewire('employees.graph', ['user' => $user, 'team' => Auth::user()->currentTeam])
</div>
