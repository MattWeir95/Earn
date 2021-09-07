<div x-data class="gap-1 p-8 items-center rounded-xl shadow-xl pb-4 bg-gradient-to-b from-indigo-300 to-indigo-400">


    

    <form action={{ route('editForm') }} method="POST" class=""
        {{-- I am setting old input values into the x-data here so i can access them again when the page re-loads --}}
        x-data="
        {message: '', 
        oldName: '{{ old('rule_name') }}', 
        oldStartDate: '{{ old('start_date') }}', 
        oldEndDate: '{{ old('end_date') }}', 
        oldPercentage: '{{ old('percentage') }}', 
        oldActive: '{{ old('active') }}'}" 
        {{-- Grabs the rule from the event sent by the rule_list --}}
        @custom-sendrule.window="  
        message=$event.detail.message;">
        @csrf

        {{-- In each of these i have a x-model which sets the value of the input, 
        if there is a value coming in from the rule_list it is that other wise it is the old value --}}

        {{-- Rule Name --}}
        <div class="mx-4">
            <label class="text-white" for="rule_name">Name</label>
            <input id="rule_name" name="rule_name" type="text" x-model="message.rule_name ? message.rule_name : oldName"
                class=" mt-2 w-full rounded-lg border-gray-400 @error('rule_name') border-red-400 border-1 @enderror" />


        </div>

        {{-- Start Date --}}
        <div class="mx-4 mt-2">
            <label for="start_date" class="text-white">Start Date</label>
            <input x-model="message.start_date ? message.start_date : oldStartDate" id="start_date" name="start_date"
                type="date"
                class="mt-1 w-full rounded-lg border-gray-400 @error('start_date') border-red-400 border-1 @enderror" />
        </div>

        {{-- End Date --}}
        <div class="mx-4 mt-2">
            <label class="text-white" for="end_date">End Date</label>
            <input x-model="message.end_date ? message.end_date : oldEndDate" id="end_date" name="end_date" type="date"
                class="mt-1 w-full rounded-lg border-gray-400 @error('end_date') border-red-400 border-1 @enderror" />
        </div>

        {{-- Percentage --}}
        <div class="mx-4 mt-2">
            <label class="text-white" for="commision_amount">Commission (%)</label>
            <input x-model="message.percentage ? message.percentage : oldPercentage" id="commision_amount"
                name="percentage" type="number"
                class="mt-1 w-full rounded-lg border-gray-400 @error('percentage') border-red-400 border-1 @enderror" />
        </div>


        {{-- Active? --}}
        <div class="flex justify-center items-center mt-1 text-white">
            <label for="active" class="mr-2">Active</label>
            <input x-model="message.active ? message.active : oldActive" id="active" name="active" type="checkbox"
                class="rounded  focus:ring-0">
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