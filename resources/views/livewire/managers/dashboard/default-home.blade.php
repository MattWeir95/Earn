<div class="py-12 mx-auto">
    <div
        class="pt-8 text-center text-white rounded-xl shadow-xl bg-gradient-to-b from-indigo-300 to-indigo-400 main-div-height">
        <div x-data="{showHeading: false}" x-cloak x-show="showHeading" class="text-5xl lg:text-7xl"
            x-transition:enter="ease-out duration-1000" x-transition:enter-start="opacity-0 scale-90"
            x-transition:enter-end="opacity-100 scale-1000" x-init="setTimeout(() => showHeading = true, 600)">
            Welcome! &#128075;</div>
        <div class="mt-36 text-2xl lg:text-4xl p-2" x-data="{showSub: false}" x-cloak x-show="showSub"
            x-transition:enter="ease-out duration-1000"
            x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-1000"
            x-init="setTimeout(() => showSub = true, 800)">
            Get your new Earn team started by inviting your team members <a class="font-bold animate-pulse" href="{{ route('teams.show', Auth::user()->currentTeam->id) }}">here</a>
        </div>

    </div>
</div>
