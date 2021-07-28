<div class="bg-white border-2 border-gray-200 w-8/12 rounded md:w-3/12">
 
    <div class="flex flex-row justify-between mx-2">
        <h1 class="font-bold">New Rule</h1>
        <button>X</button>
    </div>

    <div class="mx-4 mt-4">
        <x-jet-label for="rule_name" value="{{ __('Rule Name') }}" />
        <x-jet-input id="rule_name" type="text" class="mt-1 block w-full" wire:model.defer="state.rule_name" autocomplete="rule_name" />
    </div>

    <div class="mx-4 mt-4">
        <x-jet-label for="start_date" value="{{ __('Start Date') }}" />
        <x-jet-input id="start_date" type="date" class="mt-1 block w-full" wire:model.defer="state.start_date" autocomplete="start_date" />
    </div>
    <div class="mx-4 mt-4">
        <x-jet-label for="end_date" value="{{ __('End Date') }}" />
        <x-jet-input id="end_date" type="date" class="mt-1 block w-full" wire:model.defer="state.end_date" autocomplete="end_date" />
    </div>
    <div class="mx-4 mt-4">
        <x-jet-label for="commision_amount" value="{{ __('Commision Amount %') }}" />
        <x-jet-input id="commision_amount" type="number" class="mt-1 block w-full" wire:model.defer="state.commision_amount" autocomplete="commision_amount" />
    </div>

    <div class="flex justify-center mt-4 mb-2">
        <button class="text-blue-400 border border-blue-400 rounded-lg px-2 mx-2 transform hover:bg-blue-400 hover:text-white">Save</button>
        <button class="bg-blue-400 text-white  rounded-lg px-2 mx-2 hover:bg-white hover:text-blue-400 hover:border border-blue-400 border">Cancel</button>

    </div>
 
</div>


