<x-app-layout>
    @if (Gate::check('isManager', Auth::user()->currentTeam))
    <h1>Rules Page</h1>
    @else
    <script>window.location = "/dashboard";</script>
    @endif
</x-app-layout>