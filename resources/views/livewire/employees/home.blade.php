<widget-container class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:p-12 pt-12">
        @livewire('employees.guage', ['user' => Auth::user()])
        @livewire('employees.graph', ['user' => Auth::user()])
</widget-container>

