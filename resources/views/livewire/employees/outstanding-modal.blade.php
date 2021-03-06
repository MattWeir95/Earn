<div x-data="{isOpen: false}" id="approval-modal" x-cloak x-show="isOpen" @keydown.escape.window="isOpen = false"
    class="absolute inset-10 z-10 flex items-center justify-center" x-transition:enter="ease-out duration-300"
    x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
    x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 transform scale-100"
    x-transition:leave-end="opacity-0 transform scale-90" x-init="setTimeout(() => isOpen = true, 1000)">
    <div class="bg-white border-2 border-gray-200 rounded p-2 text-center">
        <div @click="isOpen= false" class="flex flex-row justify-end">
            <h1 class="font-bold text-2xl mr-2 md:mr-14">Commission Approval</h1>
            <button class="">X</button>
        </div>
        <div>
            <p class="text-md mt-6">Your previous commission period is pending approval</p>
            <p class="text-xl mt-6">Total: ${{ $approval[0]['total'] }}</p>
            <p class="text-md mt-2 font-semibold">Active Period
            
            </p>
            <p class="text-md mt-2">{{ $approval[0]['start_time'] }}-{{ $approval[0]['end_time'] }}</p>
        </div>

        <div class="flex justify-center pt-2 mt-6">
            <button id={{ $approval[0]['id'] }}
                class="px-4 bg-transparent p-2 rounded-lg border-2 border-indigo-500 text-indigo-500 hover:bg-gray-100 hover:text-indigo-400 mr-4 w-24"
                @click="$wire.approve({{ $approval[0]['id'] }})">Approve</button>
            <button class="modal-close px-2 bg-indigo-500 rounded-lg text-white hover:bg-indigo-400 w-24"
                @click="$wire.flag({{ $approval[0]['id'] }})">Flag Issue</button>
        </div>
    </div>
</div>
