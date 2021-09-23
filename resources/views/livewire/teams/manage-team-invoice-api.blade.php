    <div class="mt-10 sm:mt-0">
        <x-jet-action-section>
            <x-slot name="title">
                {{ __('Active Invoice Services') }}
            </x-slot>
            <x-slot name="description">
                {{ __('The team\'s active invoice accounts.') }}
            </x-slot>
            <x-slot name="content">
                <div class="grid grid-cols-6">
                    @if (count($services) > 0)
                        @foreach ($services as $service)
                            <div class="col-start-1 col-span-3">
                                <x-jet-label value="{{ $service }}" />
                            </div>
                            <div class="col-start-6 mb-2">
                                <x-jet-button wire:click="signout('{{ $service }}')"> {{ __('Sign Out') }}                      
                                </x-jet-button>
                            </div>
                        @endforeach
                    @else
                        <div class="col-start-1 col-span-3">
                            <x-jet-label class="mb-6" value="{{ __('No Active Services') }}" />
                        </div>
                    @endif
                </div>
            </x-slot>
        </x-jet-action-section>
    </div>
