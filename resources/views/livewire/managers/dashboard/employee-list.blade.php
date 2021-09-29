<div
    class="grid-cols-1 gap-8 p-4 pt-2 text-base bg-gradient-to-b from-indigo-300 to-indigo-400 rounded-xl shadow-xl text-white h-auto">
    <employee-heading class="grid grid-cols-6">
        <div>Employee</div>
        <div class="col-start-4 col-span-2">
            <div class="flex flex-col items-start"> Commission (MTD)</div>
        </div>
    </employee-heading>
    <div x-data="{employees: {{ $employees }}, selectedEmployee: @entangle('selectedEmployee')}"
        class="h-full">
        <template x-for="employee in employees">
            <div>
                <div class="border-b-2 text-sm hover:bg-blue-300 rounded-md p-2 pt-0"
                    @click="selectedEmployee = employee.id" @click>
                    <employee-list class="grid sm: grid-cols-6 mt-5">
                        <div class="col-span-2">
                            <div x-text="employee.name"> </div>
                        </div>

                        <div class="col-start-4 justify-start">
                            <div>
                                <div class="pr-6" x-text="`$${parseFloat(employee.currentSales).toFixed(2)}`">
                                </div>
                            </div>
                        </div>

                        <div
                            class="overflow-hidden mt-1 h-2 text-xs flex rounded bg-green-200 w-full sm: col-start-6 lg: col-span-2">
                            <div style="width: 0%"
                                class="shadow-none flex flex-col whitespace-nowrap text-white justify-center bg-green-500"
                                :style="`width: ${Math.floor(parseInt(employee.currentSales) / parseInt(employee.target)*100) + '%'}`"
                                ;>
                            </div>
                        </div>
                    </employee-list>
                </div>
        </template>
        @if ($selectedEmployee != null)
            <div x-show="selectedEmployee" @click="selectedEmployee = null"
                class="absolute inset-10 z-10 flex items-center justify-center" x-cloak
                x-transition:leave="transition ease-in duration-300"
                x-transition:leave-start="opacity-100 transform scale-100"
                x-transition:leave-end="opacity-0 transform scale-90">
                @livewire('managers.dashboard.employee-modal', ['user_id' => $selectedEmployee, 'team' => Auth::user()->currentTeam])
            </div>
        @endif
    </div>

</div>
