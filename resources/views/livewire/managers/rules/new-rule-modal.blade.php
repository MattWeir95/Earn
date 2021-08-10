
<div x-data="{isOpen: false}" x-cloak x-show="isOpen"  @keydown.escape.window="isOpen = false"
    @custom-new-rule-modal.window="isOpen = true"
    class="absolute inset-10 z-10 flex items-center justify-center" x-transition:enter="ease-out duration-300"
    x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100">

    <div class="bg-white border-2 border-gray-200 rounded">
        <div @click="isOpen= false" class="flex flex-row justify-between mx-2">
            <h1 class="font-bold">New Rule</h1>
            <button>X</button>
        </div>

        <form action={{ route('newRule') }} method="POST">
            @csrf
            <div class="mx-4 mt-4">
                <label for="rule_name">Name</label>
                <input id="rule_name" name="new_rule_name" type="text" class="mt-1 w-full rounded @error('new_rule_name') border-red-400 border-1 @enderror" />
            </div>

            <div class="mx-4 mt-4">
                <label for="start_date">Start Date</label>
                <input id="start_date" name="new_start_date" type="date" class="mt-1 w-full rounded @error('new_start_date') border-red-400 border-1 @enderror" />
            </div>
            <div class="mx-4 mt-4">
                <label for="end_date">End Date</label>
                <input id="end_date" name="new_end_date" type="date" class="mt-1 w-full rounded @error('new_end_date') border-red-400 border-1 @enderror" />
            </div>
            <div class="mx-4 mt-4">
                <label for="commision_amount">Commission (%)</label>
                <input id="commision_amount" name="new_percentage" type="number" class="mt-1 w-full rounded @error('new_percentage') border-red-400 border-1 @enderror" />
            </div>

            <div  class="flex justify-center mt-4 mb-2">
                <button
                    class="px-4 bg-transparent p-3 rounded-lg border-2 border-indigo-500 text-indigo-500 hover:bg-gray-100 hover:text-indigo-400 mr-4 w-24">Save</button>
                <button type="button" @click="isOpen = false"
                    class="px-4 bg-indigo-500 p-3 rounded-lg text-white hover:bg-indigo-400 w-24">Cancel</button>

            </div>
        </form>
    </div>
</div>
