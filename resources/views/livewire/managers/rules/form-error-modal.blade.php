<div  x-data="{isOpen: true}" x-cloak x-show="isOpen"  @keydown.escape.window="isOpen = false" class="mx-14 absolute bg-white shadow-lg rounded mt-10 pb-2">
    <div class="flex justify-between">
        <div class="ml-1 font-bold">Error</div>
        <button @click="isOpen= false" class="mr-3">
            X</button>
    </div>
    
    <ul class="p-2 border border-red-600 m-2 rounded">
        @foreach($errors->all() as $error)
        <li class="text-red-600">{{ $error }}</li> 
    @endforeach
    </ul>
</div>