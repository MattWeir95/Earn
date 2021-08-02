<body x-data="{ 'homepage': true }">
    <div>
        <h1>Manager Account</h1>
        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full" @click="homepage = true">
            Homepage
          </button>
          <button @click="homepage = false" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full">
            Rule Page
          </button>

        <div x-show="homepage">
            {{-- ADD LIVEWIRE COMPONENTS HERE --}}
            <h1>Homepage</h1>
        </div>
    
        <div x-show="!homepage">
            {{-- ADD LIVEWIRE COMPONENTS HERE --}}
            <h1>Rule Page</h1>    
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js"></script>
</body>

