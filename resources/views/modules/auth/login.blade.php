<x-guest-layout>
    @include('modules.auth.partials.tabs', ['active' => 'login', 'status' => session('status')])
</x-guest-layout>
