<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<div>
    <header class="flex flex-col p-5 gap-1 justify-end border-b border-indigo-600 shadow bg-indigo-400">
        <div class="flex text-sm text-white justify-between">
            <button type="button" class="">Log out</button>
            <div class="text-xl">John Smith</div>
        </div>
        <div class="flex justify-between mt-2 text-white ">
            <div class="flex flex-row border rounded-xl bg-gradient-to-l from-indigo-300 to-indigo-400">
                <button type="button" class="border-r px-2 pb-1">Employees</button>
                <button type="button" class="px-2 pb-1">Rules</button>
            </div>
            <div class="text-white text-sm ">Manager</div>
        </div>
    </header>

    @livewire('managers.rules.view-rules-list')


    @livewire('managers.rules.new-rule-modal')

</div>

</html>