{{-- Manager Home Screen --}}
@if ($total > 0)
<widget-container class="grid grid-cols-1 lg:grid-cols-2 gap-12 p-12">
    @livewire('managers.dashboard.employee-list', ['user' => Auth::user()])
    @livewire('managers.dashboard.outstanding-carousel', 
        ['user' => Auth::user()]
    )
</widget-container>
@else
<widget-container class="grid grid-cols-1 gap-12 p-12">
    @livewire('managers.dashboard.employee-list', ['user' => Auth::user()])
</widget-container>
@endif
