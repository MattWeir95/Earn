<div x-data class="gap-1 p-8 items-center rounded-xl shadow-xl pb-4 bg-gradient-to-b from-indigo-300 to-indigo-400">




    <form wire:submit.prevent="editRule" 
        {{-- Entangle the event data so i can access it from livewire --}}
        x-data="{message: @entangle('message')}"
        {{-- Grabs the rule from the event sent by the rule_list --}}
        @custom-sendrule.window="message=$event.detail.message;">
        @csrf

        {{-- Each of these values are set from the event using x-model --}}
        {{-- Rule Name --}}
        <div class="mx-4">
            <label class="text-white" for="rule_name">Name</label>
            <input wire:model.defer="rule_name" id="rule_name" name="rule_name" type="text" x-model="message.rule_name"
                class=" mt-2 w-full rounded-lg border-gray-400 @error('rule_name') border-red-400 border-1 @enderror" />
            @error('rule_name') <span class="text-red-400 text-xs" ...>{{ $message }}</span> @enderror

        </div>

        {{-- Start Date --}}
        <div class="mx-4 mt-2">
            <label for="start_date" class="text-white">Start Date</label>
            <input wire:model.defer="start_date" x-model="message.start_date" id="start_date" name="start_date"
                type="date"
                class="mt-1 w-full rounded-lg border-gray-400 @error('start_date') border-red-400 border-1 @enderror" />
            @error('start_date') <span class="text-red-400 text-xs" ...>{{ $message }}</span> @enderror
        </div>

        {{-- End Date --}}
        <div class="mx-4 mt-2">
            <label class="text-white" for="end_date">End Date</label>
            <input wire:model.defer="end_date" x-model="message.end_date" id="end_date" name="end_date" type="date"
                class="mt-1 w-full rounded-lg border-gray-400 @error('end_date') border-red-400 border-1 @enderror" />
            @error('end_date') <span class="text-red-400 text-xs" ...>{{ $message }}</span> @enderror
        </div>

        {{-- Percentage --}}
        <div class="mx-4 mt-2">
            <label class="text-white" for="commision_amount">Commission (%)</label>
            <input wire:model.defer="percentage" x-model="message.percentage" id="commision_amount" name="percentage"
                type="number"
                class="mt-1 w-full rounded-lg border-gray-400 @error('percentage') border-red-400 border-1 @enderror" />
            @error('percentage') <span class="text-red-400 text-xs" ...>{{ $message }}</span> @enderror
        </div>

        {{-- ID --}}
        <div class="">
            {{-- This is so i can pass the ID to the edit rule component --}}
            <input wire:model.defer="rule_id" x-model="message.id" id="rule_id" name="check" type="text"
                class="hidden" />
        </div>


        {{-- Update / Delete buttons --}}
        <div class="flex flex-1 justify-around mt-10">
            <button type="submit" value="Update"
                class="text-white border border-white rounded-lg mx-1 w-28 transform hover:bg-indigo-500 hover:text-white ">Update</button>

            <button wire:click="deleteRule" type="button" value="Remove"
                class="text-white border border-white rounded-lg mx-1 w-28 transform hover:bg-indigo-500 hover:text-white ">Remove</button>
        </div>
    </form>



</div>