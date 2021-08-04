<div>
    <div
        class="flex flex-col items-center justify-center gap-1 bg-gradient-to-b from-indigo-300 to-indigo-400 rounded-xl shadow-xl p-8 text-white ">
        <div class="flex flex-col items-center justify-center m-2" x-data="{ earned: 120, target: 250 }"
            @commission-new-sale.window="earned = earned + $event.detail;"
            @commission-earned-updated.window="earned = $event.detail;"
            @commission-target-updated.window="target = $event.detail;">
            <gauge class="pt-2 relative overflow-hidden w-48 sm:w-64 h-24 sm:h-32">
                <div x-cloak
                    class="gauge-meter border-10 sm:border-20 w-48 sm:w-64 h-48 sm:h-64 text-indigo-600 border-indigo-100"
                    :style="`transform: rotate(${(45 + (Math.floor((earned/target)*100) * 1.8))}deg)`">
                </div>
                <div x-cloak
                    class="gauge-percentage absolute bottom-1 sm:bottom-2 font-semibold text-xl sm:text-5xl w-full text-center"
                    :style="`--percentage: ${Math.floor((earned/target)*100)};`">
                </div>
            </gauge>

            <gauge-info class="flex w-full py-2">
                <div class="text-xs flex-1">Current Commission</div>
                <div class="text-xs flex-0" x-text="`$${parseFloat(target).toFixed(2)}`"></div>
            </gauge-info>

            <earned-commission
                class="flex w-full items-center justify-center bg-indigo-50 shadow text-indigo-500 rounded py-2">
                <div class="px-3 text-3xl sm:text-6xl font-bold" x-text="`$${parseFloat(earned).toFixed(2)}`"></div>
            </earned-commission>

            <earned-commission-info class="flex w-full pt-2">
                <div class="text-xs">Period End Date: 31/04/2021</div>
            </earned-commission-info>
        </div>
    </div>

    <script>
        window.newSale = value => {
            window.dispatchEvent(new CustomEvent('commission-new-sale', {
                detail: value
            } ?? {
                detail: 0
            }))
        }
        window.updateCommissionEarned = value => {
            window.dispatchEvent(new CustomEvent('commission-earned-updated', {
                detail: value
            } ?? {
                detail: 0
            }))
        }
        window.updateCommissionTarget = value => {
            window.dispatchEvent(new CustomEvent('commission-target-updated', {
                detail: value
            } ?? {
                detail: 0
            }))
        }
    </script>
</div>
