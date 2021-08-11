<x-jet-section-border />
<div class="mt-10 sm:mt-0">
    <form action={{ route('targetForm') }} method="POST">
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
                    <input id="new_target" type="number" name="new_target" type="date"
                        value="{{ $team->target_commission }}" class="mt-5 block w-full" />
                    <input id="team" name="team" value="{{ $team->id }}" class="hidden" />
                </div>
            </x-slot>
            <x-slot name="actions">
                <x-jet-button>
                    {{ __('Save') }}
                </x-jet-button>
            </x-slot>
        </x-jet-form-section>
    </form>
</div>
