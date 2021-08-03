<x-app-layout>
@php
$user = Auth::user()
@endphp
    @if (Gate::check('isManager', $user->currentTeam))

    @livewire('managers.rules.view-rules-list' ,['team' => $user->currentTeam])


    @livewire('managers.rules.new-rule-modal', ['team' => $user->currentTeam])
    @else
    <script>window.location = "/dashboard";</script>
    @endif
</x-app-layout>