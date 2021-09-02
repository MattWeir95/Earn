<div x-data class="gap-1 p-8 items-center rounded-xl shadow-xl pb-4 bg-gradient-to-b from-indigo-300 to-indigo-400">


    <div class="">
        <h1 class="text-white text-center font-bold pb-5">Edit Rule</h1>
    </div>

    {{-- Selected Rule Name --}}
    <p name="selected_rule_name" id="selected_rule_name" x-data="{message: ''}" @custom-sendrule.window="
     message=$event.detail.message;" x-text="message.rule_name" class="text-white text-center"></p>

    <form action={{ route('editForm') }} method="POST" class="">
        @csrf

        {{-- Rule Name --}}
        <div class="mx-4">
            <label class="text-white" for="rule_name">Name</label>
            <input value="{{ old('rule_name') }}" id="rule_name" name="rule_name" type="text"
                class=" mt-2 w-full rounded-lg border-gray-400 @error('rule_name') border-red-400 border-1 @enderror" />


        </div>

        {{-- Start Date --}}
        <div class="mx-4 mt-2">
            <label for="start_date" class="text-white">Start Date</label>
            <input value="{{ old('start_date') }}" id="start_date" name="start_date" type="date"
                class="mt-1 w-full rounded-lg border-gray-400 @error('start_date') border-red-400 border-1 @enderror" />
        </div>

        {{-- End Date --}}
        <div class="mx-4 mt-2">
            <label class="text-white" for="end_date">End Date</label>
            <input value="{{ old('end_date') }}" id="end_date" name="end_date" type="date"
                class="mt-1 w-full rounded-lg border-gray-400 @error('end_date') border-red-400 border-1 @enderror" />
        </div>

        {{-- Percentage --}}
        <div class="mx-4 mt-2">
            <label class="text-white" for="commision_amount">Commission (%)</label>
            <input value="{{ old('percentage') }}" id="commision_amount" name="percentage" type="number"
                class="mt-1 w-full rounded-lg border-gray-400 @error('percentage') border-red-400 border-1 @enderror" />
        </div>


        {{-- Active? --}}
        <div class="flex justify-center items-center mt-1 text-white">
            <label for="active" class="mr-2">Active</label>
            <input value="{{ old('active') }}" id="active" name="active" type="checkbox" class="rounded  focus:ring-0">
        </div>
        {{-- This is so i can pass the ID to the edit rule component --}}
        <input x-data="{message: ''}" @custom-sendrule.window="
            message=$event.detail.message;" x-model="message.id" id="id" name="id" type="text" class="hidden" />

        {{-- Buttons --}}
        <div class="flex flex-1 justify-around mt-10">
            <button type="submit" value="Update" name="submitButton"
                class="text-white border border-white rounded-lg mx-1 w-28 transform hover:bg-indigo-500 hover:text-white ">Update</button>

            <button type="submit" value="Remove" name="submitButton"
                class="text-white border border-white rounded-lg mx-1 w-28 transform hover:bg-indigo-500 hover:text-white ">Remove</button>
        </div>


    </form>

    {{-- Error modal --}}
    @if($errors->any())
    @livewire('managers.rules.form-error-modal')
    @endif
</div>