<x-app-layout>
@php
$user = Auth::user()
@endphp
    @if (Gate::check('isManager', $user->currentTeam))
    <widget-container class="grid grid-cols-1 lg:grid-cols-2 gap-12 p-12">
            @livewire('managers.rules.view-rules-list' ,['team' => $user->currentTeam])
            @livewire('managers.rules.edit-rules', ['team' => $user->currentTeam])
    </widget-container>

    <div class="">
    @livewire('managers.rules.new-rule-modal', ['team' => $user->currentTeam])

    </div>

    @else
    <script>window.location = "/dashboard";</script>
    @endif
</x-app-layout>