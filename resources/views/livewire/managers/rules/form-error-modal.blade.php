<div class="flex items-center justify-center">
    <div class="flex justify-between">
    </div>
    <ul class="p-2 border border-red-600 m-2 rounded">
        @foreach ($errors->all() as $error)
            <li class="text-red-600 text-xs">{{ $error }}</li>
        @endforeach
    </ul>
</div>
