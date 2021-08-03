<x-app-layout>
@php
$user = Auth::user()
@endphp
    @if (Gate::check('isManager', $user->currentTeam))

    <div class="flex flex-col mt-10 justify-center items-center md:flex-row">
        <div  class="w-11/12 mb-4 md:mb-0 md:mx-4">
            @livewire('managers.rules.view-rules-list' ,['team' => $user->currentTeam])

        </div>
        <div class="w-11/12 md:mx-4">
            @livewire('managers.rules.edit-rules', ['team' => $user->currentTeam])
        </div>

    </div>


    <div class="">
    @livewire('managers.rules.new-rule-modal', ['team' => $user->currentTeam])

    </div>

    @else
    <script>window.location = "/dashboard";</script>
    @endif
</x-app-layout>