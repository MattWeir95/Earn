<x-app-layout>
        <div class="max-w-7xl mx-auto sm:px-2 lg:px-8 h-screen" >
            @if (Gate::check('isManager', Auth::user()->currentTeam))
                <div>
                    @livewire('managers.dashboard.home', ['user' => Auth::user()])
                </div>
            @else
                <div>
                    @livewire('employees.home')
                </div>
            @endif
        </div>
</x-app-layout>
