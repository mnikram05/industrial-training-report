@props([
    'data' => [],
])

@php
    $chartData = collect($data)
        ->map(
            fn(array $item): array => [
                'date' => (string) data_get($item, 'date', ''),
                'login' => (int) data_get($item, 'login', 0),
                'logout' => (int) data_get($item, 'logout', 0),
            ],
        )
        ->values()
        ->all();

    $timeRangeOptions = [
        '90d' => __('ui.last_3_months'),
        '30d' => __('ui.last_30_days'),
        '7d' => __('ui.last_7_days'),
    ];
@endphp

<div x-data="{
    timeRange: '90d',
    chartData: @js($chartData),
    init() {
        this.waitForChartAndRender();
        this.$watch('timeRange', () => this.renderChart());
    },
    waitForChartAndRender() {
        if (window.__renderAreaChart) {
            this.$nextTick(() => this.renderChart());
        } else {
            document.addEventListener('charts:ready', () => this.$nextTick(() => this.renderChart()));
        }
    },
    renderChart() {
        const el = this.$refs.chartContainer;
        if (el && window.__renderAreaChart && el.offsetWidth > 0) {
            window.__renderAreaChart(el, this.chartData, this.timeRange);
        } else if (el && window.__renderAreaChart) {
            // Retry after a short delay if container not ready
            setTimeout(() => this.renderChart(), 50);
        }
    }
}" class="rounded-xl border bg-card text-card-foreground shadow pt-0">
    <div class="flex items-center justify-between gap-4 border-b p-6 py-5">
        <div class="grid gap-1">
            <h3 class="font-semibold leading-none tracking-tight">{{ __('ui.authentication_activity') }}</h3>
            <p class="text-sm text-muted-foreground">{{ __('ui.showing_login_and_logout_activity') }}</p>
        </div>
        <x-select :options="$timeRangeOptions" value="90d" class="!w-auto hidden sm:block"
            x-on:change="timeRange = $event.detail.value" />
    </div>
    <div class="p-6 px-2 pt-4 sm:px-6 sm:pt-6">
        <div x-ref="chartContainer" class="h-[280px] w-full" data-react-area-chart></div>
    </div>
</div>

@once
    @push('scripts')
        @vite('resources/js/charts.jsx')
    @endpush
@endonce
