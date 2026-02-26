@props([
    'data' => [],
])

@php
    $chartData = collect($data)
        ->map(
            fn(array $item): array => [
                'role' => (string) data_get($item, 'role', ''),
                'users' => (int) data_get($item, 'users', 0),
            ],
        )
        ->filter(fn(array $item): bool => $item['role'] !== '' && $item['users'] > 0)
        ->values()
        ->all();

    $totalUsers = collect($chartData)->sum('users');
@endphp

<div class="min-h-[420px]" data-react-radial-chart data-chart-data="{{ json_encode($chartData) }}" data-show-grid="false"
    data-title="{{ __('Users by Role') }}" data-description="{{ __('Total: :count users', ['count' => $totalUsers]) }}"
    data-footer-trend="" data-footer-description="{{ __('Distribution across all roles') }}"></div>

@once
    @push('scripts')
        @vite('resources/js/charts.jsx')
    @endpush
@endonce
