<x-app-layout>
    @php
        /** @var array $home */
        $shortcuts = $home['shortcuts'];
        $portalChecklist = $home['portalChecklist'];
        $portalReadyCount = $home['portalReadyCount'];
        $portalTotalCount = $home['portalTotalCount'];
        $recentActivities = $home['recentActivities'];
    @endphp

    <div class="space-y-6 py-6 sm:py-8">
        <div class="space-y-1">
            <h2 class="text-xl font-semibold tracking-tight text-foreground sm:text-2xl">
                {{ __('dashboard.welcome', ['name' => auth()->user()->name]) }}
            </h2>
            <p class="max-w-2xl text-sm text-muted-foreground">{{ __('dashboard.intro') }}</p>
        </div>

        <div class="grid items-stretch gap-6 lg:grid-cols-2">
            <x-card module class="h-full">
                <div class="flex h-full flex-col space-y-4">
                    <h3 class="text-base font-semibold text-foreground">{{ __('dashboard.shortcuts_heading') }}</h3>
                    <ul class="grid gap-2 sm:grid-cols-2">
                        @foreach ($shortcuts as $item)
                            <li class="min-w-0">
                                <a href="{{ $item['href'] }}" @if ($item['external']) target="_blank" rel="noopener noreferrer" @endif
                                    class="flex min-h-[2.75rem] items-center rounded-lg border border-border/80 bg-background/60 px-3 py-2.5 text-sm font-medium text-foreground shadow-xs transition hover:border-[color-mix(in_srgb,var(--portal-accent)_45%,var(--border))] hover:bg-[color-mix(in_srgb,var(--portal-accent)_6%,transparent)] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[var(--portal-accent)] focus-visible:ring-offset-2">
                                    @if ($item['external'])
                                        <svg class="mr-2 size-4 shrink-0 text-[var(--portal-accent)]" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5M13.5 6L21 3m0 0v5.25M21 3h-5.25" />
                                        </svg>
                                    @else
                                        <svg class="mr-2 size-4 shrink-0 text-muted-foreground" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                                        </svg>
                                    @endif
                                    <span class="truncate">{{ $item['label'] }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                    <div class="min-h-0 flex-1" aria-hidden="true"></div>
                </div>
            </x-card>

            <x-card module class="h-full">
                <div class="flex h-full flex-col space-y-4">
                    <div class="flex flex-col gap-1 sm:flex-row sm:items-start sm:justify-between">
                        <h3 class="text-base font-semibold text-foreground">{{ __('dashboard.checklist_heading') }}</h3>
                        <p class="text-xs font-medium text-muted-foreground sm:text-right">
                            {{ __('dashboard.checklist_summary', ['ready' => $portalReadyCount, 'total' => $portalTotalCount]) }}
                        </p>
                    </div>
                    <p class="text-xs text-muted-foreground">{{ __('dashboard.checklist_hint') }}</p>
                    <ul class="divide-y divide-border/70">
                        @foreach ($portalChecklist as $row)
                            <li class="flex flex-col gap-2 py-3 sm:flex-row sm:items-center sm:justify-between">
                                <div class="min-w-0 flex items-center gap-2">
                                    @if ($row['ready'])
                                        <span
                                            class="inline-flex shrink-0 items-center rounded-full bg-emerald-500/15 px-2 py-0.5 text-[11px] font-semibold text-emerald-800 dark:text-emerald-400">
                                            {{ __('dashboard.status_ready') }}
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex shrink-0 items-center rounded-full bg-amber-500/15 px-2 py-0.5 text-[11px] font-semibold text-amber-900 dark:text-amber-300">
                                            {{ __('dashboard.status_needs_work') }}
                                        </span>
                                    @endif
                                    <span class="truncate text-sm font-medium text-foreground">{{ $row['label'] }}</span>
                                </div>
                                <a href="{{ $row['edit_url'] }}"
                                    class="shrink-0 text-sm font-medium text-[var(--portal-accent)] underline-offset-2 hover:underline focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[var(--portal-accent)] focus-visible:ring-offset-2 rounded-sm">
                                    {{ __('dashboard.edit') }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </x-card>
        </div>

        @if ($recentActivities->isNotEmpty())
            <x-card module>
                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <h3 class="text-base font-semibold text-foreground">{{ __('dashboard.recent_activity') }}</h3>
                    <a href="{{ route('activity-logs.index') }}"
                        class="text-sm font-medium text-[var(--portal-accent)] underline-offset-2 hover:underline focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[var(--portal-accent)] focus-visible:ring-offset-2 rounded-sm">
                        {{ __('dashboard.view_all_logs') }}
                    </a>
                </div>
                <ul class="mt-4 divide-y divide-border/70" role="list">
                    @foreach ($recentActivities as $activity)
                        <li class="py-3">
                            <a href="{{ route('activity-logs.show', $activity) }}"
                                class="group block rounded-md focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[var(--portal-accent)] focus-visible:ring-offset-2 -mx-1 px-1">
                                <p class="text-sm text-foreground group-hover:text-[var(--portal-accent)]">
                                    {{ \Illuminate\Support\Str::limit($activity->description ?? '—', 120) }}
                                </p>
                                <p class="mt-1 flex flex-wrap items-center gap-x-2 text-xs text-muted-foreground">
                                    <span>{{ $activity->created_at?->diffForHumans() }}</span>
                                    @if ($activity->causer)
                                        <span class="text-border">·</span>
                                        <span class="truncate">{{ $activity->causer->name }}</span>
                                    @endif
                                </p>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </x-card>
        @endif
    </div>
</x-app-layout>
