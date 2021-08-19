<x-app-layout>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" >
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
