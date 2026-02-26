<x-guest-layout>
    @include('modules.auth.partials.tabs', ['active' => 'register', 'status' => session('status')])
</x-guest-layout>
