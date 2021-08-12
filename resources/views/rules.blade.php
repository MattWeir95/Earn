<x-app-layout>
    @php
        $user = Auth::user();
    @endphp
    @if (Gate::check('isManager', $user->currentTeam))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" >
            <widget-container class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:p-12 pt-12">
                @livewire('managers.rules.view-rules-list' ,['team' => $user->currentTeam])
                @livewire('managers.rules.edit-rules', ['team' => $user->currentTeam])
            </widget-container>
            <div>
                @livewire('managers.rules.new-rule-modal', ['team' => $user->currentTeam])
            </div>
        </div>

    @else
        <script>
            window.location = "/dashboard";
        </script>
    @endif
</x-app-layout>
