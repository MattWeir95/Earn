<div x-data="{isOpen: true}" x-cloak x-show="isOpen" @keydown.escape.window="isOpen = false"
    style="background-color: rgba(0,0,0,0)"
    class="absolute inset-0.5 z-10 flex items-center justify-center"
    @click="isOpen = false">
    <div class="bg-white shadow-lg rounded pb-2 mb-8 border border-black">
        <div class="flex justify-between">
            <div class="ml-1 font-bold">Error</div>
            <button @click="isOpen= false" class="mr-3">
                X</button>
        </div>
    
        <ul class="p-2 border border-red-600 m-2 rounded">
            @foreach ($errors->all() as $error)
                <li class="text-red-600">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    
</div>
