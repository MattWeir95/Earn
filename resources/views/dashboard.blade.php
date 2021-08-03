<x-app-layout>
    <body x-data="{ 'homepage': true }">
        @if (Gate::check('isManager', Auth::user()->currentTeam))
            <div class="py-6 px-4">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div>
                        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold px-4 rounded-full"
                            @click="homepage = true">
                            Home
                        </button>
                        <button @click="homepage = false"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold px-4 rounded-full">
                            Rules
                        </button>
                    </div>
                </div>
            </div>
        @endif
        <div>
            @if (Gate::check('isManager', Auth::user()->currentTeam))
                <div x-show="homepage">
                    {{-- ADD LIVEWIRE COMPONENTS HERE --}}
                    <h1>Manager Homepage</h1>
                </div>

                <div x-show="!homepage">
                    {{-- ADD LIVEWIRE COMPONENTS HERE --}}
                    <h1>Manager Rule Page</h1>
                </div>
            @else
                <div x-show="homepage">
                    {{-- ADD LIVEWIRE COMPONENTS HERE --}}
                    <h1>Employee Homepage</h1>
                </div>
            @endif
        </div>
        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js"></script>
    </body>
</x-app-layout>
