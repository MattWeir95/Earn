<x-jet-action-section>
    <div class="mt-10 sm:mt-0">
        <x-slot name="title">
            {{ __('Active Invoice Services') }}
        </x-slot>
        <x-slot name="description">
            {{ __('The team\'s active invoice accounts.') }}
        </x-slot>  
        <x-slot name="content">
            <x-jet-label class="mb-6 font-bold" value="{{ __('Active Accounts') }}" />
            <div class="grid grid-cols-6">
                @foreach ($services as $service)
                    <div class="col-start-1 col-span-3">
                        <x-jet-label value="{{ $service->name }}" />
                    </div>
                    <div class="col-start-5 col-span-2 mb-2">
                        <x-jet-button wire:click="signout({{ $service->name }})"> {{ __('Sign Out') }} </x-jet-button>        
                    </div>
                @endforeach
            </div>
        </x-slot>
    </div>
</x-jet-action-section>
