<div class="mt-10 sm:mt-0">
    <form wire:submit.prevent="updateTarget" >
        @csrf
        <x-jet-form-section submit="">
            <div>Commission Target</div>
            <x-slot name="title">
                {{ __('Commission Target') }}
            </x-slot>
            <x-slot name="description">
                {{ __('Specify the commission target for employees.') }}
            </x-slot>
            <x-slot name="form">
                <div class="col-span-6 sm:col-span-4">
                    <x-jet-label for="name" value="{{ __('Commission Target ($)') }}" />
                    <input wire:model="target" id="target" type="number" name="target"
                        class="mt-5 block w-full"/>
                        @error('target') <span class="text-red-400 text-xs" ...>Invalid Sales Target</span> @enderror
                    <input id="team" name="team" value="{{ $team->id }}" class="hidden" />
                    <div id="UI_testing" class="hidden">{{ $target }}</div>
                </div>
            </x-slot>
            <x-slot name="actions">
                <x-jet-button type="submit">
                    {{ __('Save') }}
                </x-jet-button>
            </x-slot>
        </x-jet-form-section>
    </form>
</div>
