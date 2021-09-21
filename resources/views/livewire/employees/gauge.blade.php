<div>
    <div
        class="flex flex-col items-center justify-center gap-1 bg-gradient-to-b from-indigo-300 to-indigo-400 rounded-xl shadow-xl py-6 pb-6 px-10 text-white ">
        <div class="flex flex-col items-center justify-center m-2"
            x-data="{ earned: {{ $currentSales }}, target: {{ $target }} }">
            @if ($currentSales < $target)
                <gauge class="pt-2 relative overflow-hidden w-48 sm:w-64 h-24 sm:h-32">
                    <div x-cloak
                        class="gauge-meter border-8 sm:border-20 w-48 sm:w-64 h-48 sm:h-64 text-indigo-600 border-indigo-100"
                        :style="`transform: rotate(${(45 + (Math.floor((earned/target)*100) * 1.8))}deg)`">
                    </div>
                    <div x-cloak
                        class="gauge-percentage absolute bottom-1 sm:bottom-2 font-semibold text-xl sm:text-5xl w-full text-center"
                        :style="`--percentage: ${Math.floor((earned/target)*100)};`">
                    </div>
                </gauge>
            @else
            <gauge class="pt-2 relative overflow-hidden w-48 sm:w-64 h-24 sm:h-32">
                <div x-cloak
                    class="gauge-meter border-8 sm:border-20 w-48 sm:w-64 h-48 sm:h-64 text-indigo-600 border-indigo-100"
                    :style="`transform: rotate(${(45 + (Math.floor(100) * 1.8))}deg)`">
                </div>
                <div x-cloak
                    class="gauge-percentage absolute bottom-1 sm:bottom-2 font-semibold text-xl sm:text-5xl w-full text-center"
                    :style="`--percentage: ${Math.floor((earned/target)*100)};`">
                </div>
            </gauge>
            @endif


            <gauge-info class="flex w-full py-2">
                <div class="text-xs flex-1">Current Commission</div>
                <div class="text-xs flex-0" x-text="`$${parseFloat(target).toFixed(2)}`"></div>
            </gauge-info>

            <earned-commission
                class="flex w-full items-center justify-center bg-indigo-50 shadow text-indigo-500 rounded py-2">
                <div class="px-3 text-3xl sm:text-6xl font-bold" x-text="`$${parseFloat(earned).toFixed(2)}`"></div>
            </earned-commission>

            <earned-commission-info class="grid grid-cols-2 pt-2 w-full">
                <div class="text-xs">Period End Date:</div>
                <div class="text-xs justify-self-end">{{ $periodEndDate }}</div>
            </earned-commission-info>
        </div>
    </div>
</div>
