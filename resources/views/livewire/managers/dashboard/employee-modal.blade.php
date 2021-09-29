<div x-cloak id="employee-modal" class="p-4 text-black bg-white rounded-lg shadow-lg border-2 border-blue-300">
    <div class="text-center pb-2 text-lg font-semibold">{{ $user->first_name . " " . $user->last_name }}</div>
    @livewire('employees.gauge', ['user' => $user, 'team' => Auth::user()->currentTeam])
    <div class="pt-2"></div>
    @livewire('employees.graph', ['user' => $user, 'team' => Auth::user()->currentTeam])
</div>
