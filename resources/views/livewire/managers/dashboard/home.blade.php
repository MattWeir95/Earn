{{-- Manager Home Screen --}}
@if ($total > 0)
{{-- Outstanding Commission Aprovals --}}
<widget-container id="carousel-visible" class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:p-12 pt-12">
    @livewire('managers.dashboard.employee-list', ['user' => Auth::user()])
    @livewire('managers.dashboard.outstanding-carousel', 
        ['user' => Auth::user()]
    )
</widget-container>
@else
{{-- No Approvals --}}
<widget-container id="carousel-hidden" class="grid grid-cols-1 gap-12 lg:p-12 pt-12">
    @livewire('managers.dashboard.employee-list', ['user' => Auth::user()])
</widget-container>
@endif
