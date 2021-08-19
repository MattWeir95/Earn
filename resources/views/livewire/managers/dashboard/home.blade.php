{{-- Manager Home Screen --}}
@if ($total > 0)
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" >
<widget-container class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:p-12 pt-12">
    @livewire('managers.dashboard.employee-list', ['user' => Auth::user()])
    @livewire('managers.dashboard.outstanding-carousel', 
        ['user' => Auth::user()]
    )
</widget-container>
</div>
@else
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" >
<widget-container class="grid grid-cols-1 gap-12 lg:p-12 pt-12">
    @livewire('managers.dashboard.employee-list', ['user' => Auth::user()])
</widget-container>
</div>
@endif
