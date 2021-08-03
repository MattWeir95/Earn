<x-app-layout>
        <div>
            @if (Gate::check('isManager', Auth::user()->currentTeam))
                <div>
                    {{-- ADD LIVEWIRE COMPONENTS HERE --}}
                    <h1>Manager Homepage</h1>
                </div>
            @else
                <div>
                    {{-- ADD LIVEWIRE COMPONENTS HERE --}}
                    <h1>Employee Homepage</h1>
                </div>
            @endif
        </div>
</x-app-layout>
