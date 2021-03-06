<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Settings') }}
        </h2>
    </x-slot>
    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            @livewire('teams.update-team-name-form', ['team' => $team])

            @livewire('teams.team-member-manager', ['team' => $team])
            @if (Gate::check('isManager', Auth::user()->currentTeam))
            <x-jet-section-border />
            @livewire('teams.manage-team-target', ['team' => $team])
            @endif

            <x-jet-section-border />
            @livewire('teams.manage-team-invoice-api', ['team' => $team])

            <x-jet-section-border />
            @livewire('teams.add-team-invoice-api', ['team' => $team]) 

            @if (Gate::check('delete', $team) && ! $team->personal_team)
                <x-jet-section-border />

                <div class="mt-10 sm:mt-0">
                    @livewire('teams.delete-team-form', ['team' => $team])
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
