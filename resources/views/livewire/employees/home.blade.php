{{-- Employee Home Screen --}}
<widget-container class="grid grid-cols-1 lg:grid-cols-2 gap-12 p-12" >
        @livewire('employees.guage', ['user' => Auth::user()])
        @livewire('employees.graph')
</widget-container>

