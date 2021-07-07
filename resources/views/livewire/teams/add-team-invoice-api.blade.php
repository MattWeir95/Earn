<x-jet-action-section>
    <div class="mt-10 sm:mt-0">
        <x-slot name="title">
            {{ __('Add New Invoice Services') }}
        </x-slot>
        <x-slot name="description">
            {{ __('Add additonal services that are supported through Earn.') }}
        </x-slot>  
        <x-slot name="content">
            <div class="grid grid-cols-6">
                @foreach ($services as $service)
                    <div class="col-start-1 col-span-3">
                        <x-jet-label value="{{ $service->app_name }}" />
                    </div>
                    <div class="col-start-5 col-span-2 mb-2">
                        <x-jet-button wire:click="signin({{ $service }})"> {{ __('Sign In') }} </x-jet-button>  
                    </div>
                @endforeach
            </div>
        </x-slot>
    </div>
</x-jet-action-section>