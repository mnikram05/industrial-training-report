@props([
    'data' => [],
])

@php
    $chartData = collect($data)
        ->map(
            fn(array $item): array => [
                'name' => (string) data_get($item, 'name', ''),
                'visitors' => (int) data_get($item, 'count', 0),
            ],
        )
        ->filter(fn(array $item): bool => $item['name'] !== '' && $item['visitors'] > 0)
        ->values()
        ->all();

    $total = collect($chartData)->sum('visitors');
@endphp

<div class="min-h-[420px]" data-react-radial-chart data-chart-data="{{ json_encode($chartData) }}" data-show-grid="true"
    data-title="{{ __('Activity by Category') }}" data-description="{{ __('Total: :count events', ['count' => $total]) }}"
    data-footer-trend="" data-footer-description="{{ __('All activity log categories') }}"></div>

@once
    @push('scripts')
        @vite('resources/js/charts.jsx')
    @endpush
@endonce
