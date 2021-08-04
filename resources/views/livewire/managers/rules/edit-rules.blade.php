<div x-data
    class="flex flex-col items-center border border-2 border-white rounded-lg p-2 bg-gradient-to-b from-indigo-300 to-indigo-400">


    <form action={{ route('UpdateRule') }} method="POST" class="">
        @csrf

        {{-- Rule Name --}}
        <div class="mx-4 mt-4">
            <label class="text-white" for="rule_name">Name</label>
            <input x-data="{message: ''}" @custom-sendrule.window="
            message=$event.detail.message;" x-model="message.rule_name" id="rule_name" name="rule_name" type="text"
                class="mt-1 w-full rounded-lg border-gray-400" />
        </div>

        {{-- Start Date --}}
        <div class="mx-4 mt-4">
            <label for="start_date" class="text-white">Start Date</label>
            <input x-data="{message: ''}" @custom-sendrule.window="
            message=$event.detail.message;" x-model="message.start_date" id="start_date" name="start_date" type="date"
                class="mt-1 w-full rounded-lg border-gray-400" />
        </div>

        {{-- End Date --}}
        <div class="mx-4 mt-4">
            <label class="text-white" for="end_date">End Date</label>
            <input x-data="{message: ''}" @custom-sendrule.window="
            message=$event.detail.message;" x-model="message.end_date" id="end_date" name="end_date" type="date"
                class="mt-1 w-full rounded-lg border-gray-400" />
        </div>

        {{-- Percentage --}}
        <div class="mx-4 mt-4">
            <label class="text-white" for="commision_amount">Commission (%)</label>
            <input x-data="{message: ''}" @custom-sendrule.window="
            message=$event.detail.message;" x-model="message.percentage" id="commision_amount" name="percentage"
                type="number" class="mt-1 w-full rounded-lg border-gray-400" />
        </div>

        {{-- Active? --}}
        <div class="flex justify-center items-center mt-2 text-white">
            <label for="active" class="mr-2">Active</label>
            <input x-data="{message: ''}" @custom-sendrule.window="
        message=$event.detail.message;" x-model="message.active" id="active" name="active" type="checkbox" class="">

        </div>
        {{-- This is so i can pass the ID to the edit rule component --}}
        <input x-data="{message: ''}" @custom-sendrule.window="
            message=$event.detail.message;" x-model="message.id" id="id" name="id" type="text" class="hidden" />

        {{-- Buttons --}}
        <div class="flex flex-1 justify-around mt-4 mb-2">
            <button type="submit"
                class="text-white border border-white rounded-lg px-1 transform hover:bg-indigo-500 hover:text-white ">Update</button>
            <button type="button"
                class="text-white border border-white rounded-lg px-1 transform hover:bg-indigo-500 hover:text-white ">Remove</button>

        </div>
    </form>
</div>