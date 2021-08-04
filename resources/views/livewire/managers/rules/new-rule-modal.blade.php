<head>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
</head>
<style>

    [x-cloak] {
      display: none;
    }
  
  </style>

<div x-data="{isOpen: false}" x-cloak x-show="isOpen"  @keydown.escape.window="isOpen = false"
    @custom-new-rule-modal.window="isOpen = true"
    class="absolute z-50 top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-8/12" >

    <div class="bg-white border-2 border-gray-200  rounded">

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
                    class="text-blue-400 border border-blue-400 rounded-lg px-2 mx-2 transform hover:bg-blue-400 hover:text-white pb-1">Save</button>
                <button type="button" @click="isOpen = false"
                    class="bg-blue-400 text-white rounded-lg px-2 mx-2 hover:bg-white hover:text-blue-400 hover:border border-blue-400 border pb-1">Cancel</button>

            </div>
        </form>
    </div>
</div>
