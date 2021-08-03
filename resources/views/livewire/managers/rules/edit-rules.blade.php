<div x-data  
    class="flex flex-col items-center border border-2 border-white rounded-lg p-2 bg-gradient-to-b from-indigo-300 to-indigo-400">


    <form class="">
        @csrf
        <div class="mx-4 mt-4">
            <label class="text-white" for="rule_name">Name</label>
            <input 
            x-data="{message: ''}" 
            @custom-sendrule.window="
            message=$event.detail.message;"   
            x-model="message.rule_name"
             id="rule_name" name="rule_name" type="text"
                class="mt-1 w-full rounded-lg border-gray-400" />
        </div>

        <div class="mx-4 mt-4">
            <label for="start_date" class="text-white">Start Date</label>
            <input 
            x-data="{message: ''}" 
            @custom-sendrule.window="
            message=$event.detail.message;"
            x-model="message.start_date"
            id="start_date" name="start_date" type="date" class="mt-1 w-full rounded-lg border-gray-400" />
        </div>
        <div class="mx-4 mt-4">
            <label class="text-white" for="end_date">End Date</label>
            <input 
            x-data="{message: ''}" 
            @custom-sendrule.window="
            message=$event.detail.message;"
            x-model="message.end_date"
            id="end_date" name="end_date" type="date" class="mt-1 w-full rounded-lg border-gray-400" />
        </div>
        <div class="mx-4 mt-4">
            <label class="text-white" for="commision_amount">Commission (%)</label>
            <input 
            x-data="{message: ''}" 
            @custom-sendrule.window="
            message=$event.detail.message;"
            x-model="message.percentage"
            id="commision_amount" name="percentage" type="number"
            class="mt-1 w-full rounded-lg border-gray-400" />
        </div>
        <div 
        
        class="flex justify-center items-center mt-2 text-white">
        <label for="active" class="mr-2">Active</label>
        <input
        x-data="{message: ''}" 
        @custom-sendrule.window="
        message=$event.detail.message;"
        x-model="message.active" type="checkbox" class="">
        
    </div>
        <div class="flex flex-1 justify-around mt-4 mb-2">
            <button type="button"
                class="text-white border border-white rounded-lg px-1 transform hover:bg-indigo-500 hover:text-white ">Update</button>
            <button type="button"
                class="text-white border border-white rounded-lg px-1 transform hover:bg-indigo-500 hover:text-white ">Remove</button>

        </div>
    </form>
</div>



