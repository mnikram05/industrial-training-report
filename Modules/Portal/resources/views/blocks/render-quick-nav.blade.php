@php
    $d = $block['data'];
    $navItems = $d['items'] ?? [];
@endphp
@if (count($navItems))
    <section class="pb-20 pt-4">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            @if (!empty($d['heading_' . $l]))
                <h2 class="mb-8 text-xl font-bold" style="color: var(--portal-text)">{{ $d['heading_' . $l] }}</h2>
            @endif

            <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($navItems as $item)
                    <a href="{{ !empty($item['url']) ? url($item['url']) : '#' }}"
                        class="portal-stagger-item group flex items-center justify-between rounded-2xl border border-gray-100/50 p-6 shadow-md transition-all duration-300 hover:-translate-y-1 hover:shadow-xl" style="background-color: var(--portal-card-bg)">
                        <div class="flex items-center gap-4">
                            <div class="flex size-12 items-center justify-center rounded-xl shadow-sm transition-all duration-300 group-hover:scale-110 group-hover:shadow-md" style="background-color: color-mix(in srgb, var(--portal-accent) 10%, transparent); color: var(--portal-accent)">
                                @if (!empty($item['icon']))
                                    <span class="text-xl">{{ $item['icon'] }}</span>
                                @else
                                    <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                    </svg>
                                @endif
                            </div>
                            <div>
                                <h3 class="text-sm font-bold" style="color: var(--portal-text)">{{ $item['title_' . $l] ?? '' }}</h3>
                                @if (!empty($item['subtitle_' . $l]))
                                    <p class="mt-0.5 text-xs text-gray-400">{{ $item['subtitle_' . $l] }}</p>
                                @endif
                            </div>
                        </div>
                        <svg class="size-5 text-gray-300 transition-all duration-300 group-hover:translate-x-1.5 group-hover:text-gray-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                        </svg>
                    </a>
                @endforeach
            </div>
        </div>
    </section>
@endif
