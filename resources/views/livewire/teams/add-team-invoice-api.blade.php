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
                @if (count($services) > 0)
                    @foreach ($services as $service)
                        <div class="col-start-1 col-span-3">
                            <x-jet-label value="{{ $service->app_name }}" />
                        </div>
                        <div class="col-start-6 mb-2">
                            <x-jet-button wire:click="signin({{ $service }})"> {{ __('Sign In') }} </x-jet-button>  
                        </div>
                    @endforeach
                    @else
                    <div class="col-start-1 col-span-3">
                        <x-jet-label class="mb-6" value="{{ __('No Additional Services Available') }}" /> 
                    </div>
                    @endif
            </div>
        </x-slot>
    </div>
</x-jet-action-section>