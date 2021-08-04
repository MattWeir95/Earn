<div x-data
    class="flex flex-col items-center border border-2 border-white rounded-lg p-2 bg-gradient-to-b from-indigo-300 to-indigo-400">

    <form action={{ route('editForm') }} method="POST" class="">
        @csrf

        {{-- Rule Name --}}
        <div class="mx-4 mt-2">
            <label class="text-white" for="rule_name">Name</label>
            <input x-data="{message: ''}" @custom-sendrule.window="
            message=$event.detail.message;" x-model="message.rule_name" id="rule_name" name="rule_name" type="text" value=""
                class=" mt-1 w-full rounded-lg border-gray-400 @error('rule_name') border-red-400 border-1 @enderror" />
             {{-- @error('rule_name')
            @if($message == "The rule name must not be greater than 10 characters.")
            <p class="text-xs text-red-600 px-1 m-0 py-0">Max 15 characters</p>
            @endif
             @enderror   --}}
        </div>

        {{-- Start Date --}}
        <div class="mx-4 mt-2">
            <label for="start_date" class="text-white">Start Date</label>
            <input x-data="{message: ''}" @custom-sendrule.window="
            message=$event.detail.message;" x-model="message.start_date" id="start_date" name="start_date" type="date"
                class="mt-1 w-full rounded-lg border-gray-400 @error('start_date') border-red-400 border-1 @enderror" />
        </div>

        {{-- End Date --}}
        <div class="mx-4 mt-2">
            <label class="text-white" for="end_date">End Date</label>
            <input x-data="{message: ''}" @custom-sendrule.window="
            message=$event.detail.message;" x-model="message.end_date" id="end_date" name="end_date" type="date"
                class="mt-1 w-full rounded-lg border-gray-400 @error('end_date') border-red-400 border-1 @enderror" />
        </div>

        {{-- Percentage --}}
        <div class="mx-4 mt-2">
            <label class="text-white" for="commision_amount">Commission (%)</label>
            <input x-data="{message: ''}" @custom-sendrule.window="
            message=$event.detail.message;" x-model="message.percentage" id="commision_amount" name="percentage"
                type="number" class="mt-1 w-full rounded-lg border-gray-400 @error('percentage') border-red-400 border-1 @enderror" />
        </div>
        

        {{-- Active? --}}
        <div class="flex justify-center items-center mt-2 text-white">
            <label for="active" class="mr-2">Active</label>
            <input x-data="{message: ''}" @custom-sendrule.window="
        message=$event.detail.message;" x-model="message.active" id="active" name="active" type="checkbox" class="rounded  focus:ring-0">
    
        </div>
        {{-- This is so i can pass the ID to the edit rule component --}}
        <input x-data="{message: ''}" @custom-sendrule.window="
            message=$event.detail.message;" x-model="message.id" id="id" name="id" type="text" class="hidden" />

        {{-- Buttons --}}
        <div class="flex flex-1 justify-around mt-4 mb-2">

            <button type="submit" value="Update" name="submitButton"
                class="text-white border border-white rounded-lg px-1 transform hover:bg-indigo-500 hover:text-white ">Update</button>

            <button type="submit" value="Remove" name="submitButton"
                class="text-white border border-white rounded-lg px-1 transform hover:bg-indigo-500 hover:text-white ">Remove</button>

        </div>


    </form>

</div>