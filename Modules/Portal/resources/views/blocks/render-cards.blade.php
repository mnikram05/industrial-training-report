@php $d = $block['data']; $items = $d['items'] ?? []; $layout = $d['layout'] ?? 'centered'; @endphp
@if (count($items))
    <section class="relative -mt-8 pb-12">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">

            @if ($layout === 'horizontal')
                {{-- Horizontal: icon left, text right --}}
                <div class="grid gap-4 sm:grid-cols-2">
                    @foreach ($items as $card)
                        <div class="portal-stagger-item group flex items-center gap-5 rounded-2xl border border-gray-100/50 p-6 shadow-lg transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl" style="background-color: var(--portal-card-bg)">
                            <div class="flex shrink-0 items-center justify-center overflow-hidden rounded-xl shadow-inner transition-transform duration-300 group-hover:scale-110" style="width:4rem;height:4rem;min-width:4rem;min-height:4rem;background-color: color-mix(in srgb, var(--portal-accent) 8%, transparent)">
                                @if (!empty($card['image']))
                                    <img src="{{ Storage::disk('public')->url($card['image']) }}" alt="{{ $card['label_' . $l] ?? '' }}" class="h-full w-full rounded-xl object-cover" />
                                @elseif (!empty($card['icon']))
                                    <span class="text-2xl">{{ $card['icon'] }}</span>
                                @endif
                            </div>
                            <div>
                                <h3 class="text-xs font-extrabold uppercase tracking-[0.12em]" style="color: var(--portal-accent)">{{ $card['label_' . $l] ?? '' }}</h3>
                                <p class="mt-1 text-sm font-medium" style="color: var(--portal-text)">{{ $card['value_' . $l] ?? '' }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>

            @elseif ($layout === 'gallery')
                {{-- Photo gallery: square tiles in a row --}}
                <div class="grid grid-cols-2 gap-4 sm:grid-cols-4">
                    @foreach ($items as $card)
                        <div class="portal-stagger-item group flex flex-col overflow-hidden rounded-2xl border border-gray-100/50 shadow-lg transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl" style="background-color: var(--portal-card-bg)">
                            <div class="aspect-square w-full overflow-hidden bg-black/5">
                                @if (! empty($card['image']))
                                    <img src="{{ Storage::disk('public')->url($card['image']) }}" alt="{{ $card['label_' . $l] ?? '' }}" class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105" />
                                @elseif (! empty($card['icon']))
                                    <div class="flex h-full w-full items-center justify-center text-4xl">{{ $card['icon'] }}</div>
                                @endif
                            </div>
                            @if (! empty($card['label_' . $l]) || ! empty($card['value_' . $l]))
                                <div class="p-3 text-center">
                                    @if (! empty($card['label_' . $l]))
                                        <p class="text-xs font-bold" style="color: var(--portal-text)">{{ $card['label_' . $l] }}</p>
                                    @endif
                                    @if (! empty($card['value_' . $l]))
                                        <p class="mt-1 text-[11px] leading-snug opacity-80" style="color: var(--portal-text)">{{ $card['value_' . $l] }}</p>
                                    @endif
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>

            @elseif ($layout === 'compact')
                {{-- Compact: small inline badges --}}
                <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach ($items as $card)
                        <div class="portal-stagger-item group flex items-center gap-3 rounded-xl border border-gray-100/50 px-4 py-3 shadow-md transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl" style="background-color: var(--portal-card-bg)">
                            <div class="flex shrink-0 items-center justify-center overflow-hidden rounded-lg" style="width:2.5rem;height:2.5rem;min-width:2.5rem;min-height:2.5rem;background-color: color-mix(in srgb, var(--portal-accent) 10%, transparent)">
                                @if (!empty($card['image']))
                                    <img src="{{ Storage::disk('public')->url($card['image']) }}" alt="" class="h-full w-full rounded-lg object-cover" />
                                @elseif (!empty($card['icon']))
                                    <span class="text-lg">{{ $card['icon'] }}</span>
                                @endif
                            </div>
                            <div class="min-w-0">
                                <p class="truncate text-[10px] font-bold uppercase tracking-wide" style="color: color-mix(in srgb, var(--portal-text) 50%, transparent)">{{ $card['label_' . $l] ?? '' }}</p>
                                <p class="truncate text-sm font-semibold" style="color: var(--portal-text)">{{ $card['value_' . $l] ?? '' }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>

            @elseif ($layout === 'featured')
                {{-- Featured: first card large, rest small --}}
                <div class="grid gap-5 lg:grid-cols-3">
                    @foreach ($items as $idx => $card)
                        @if ($idx === 0)
                            <div class="portal-stagger-item group flex flex-col items-center rounded-2xl border border-gray-100/50 p-10 text-center shadow-lg transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl lg:row-span-2" style="background-color: var(--portal-card-bg)">
                                <div class="mb-5 flex items-center justify-center overflow-hidden rounded-full shadow-inner transition-transform duration-300 group-hover:scale-110" style="width:6rem;height:6rem;min-width:6rem;min-height:6rem;background-color: color-mix(in srgb, var(--portal-accent) 8%, transparent)">
                                    @if (!empty($card['image']))
                                        <img src="{{ Storage::disk('public')->url($card['image']) }}" alt="" class="h-full w-full rounded-full object-cover" />
                                    @elseif (!empty($card['icon']))
                                        <span class="text-4xl">{{ $card['icon'] }}</span>
                                    @endif
                                </div>
                                <h3 class="text-xs font-extrabold uppercase tracking-[0.15em]" style="color: var(--portal-accent)">{{ $card['label_' . $l] ?? '' }}</h3>
                                <p class="mt-3 text-base font-medium" style="color: var(--portal-text)">{{ $card['value_' . $l] ?? '' }}</p>
                            </div>
                        @else
                            <div class="portal-stagger-item group flex items-center gap-4 rounded-2xl border border-gray-100/50 p-5 shadow-lg transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl" style="background-color: var(--portal-card-bg)">
                                <div class="flex shrink-0 items-center justify-center overflow-hidden rounded-xl shadow-inner transition-transform duration-300 group-hover:scale-110" style="width:3.5rem;height:3.5rem;min-width:3.5rem;min-height:3.5rem;background-color: color-mix(in srgb, var(--portal-accent) 8%, transparent)">
                                    @if (!empty($card['image']))
                                        <img src="{{ Storage::disk('public')->url($card['image']) }}" alt="" class="h-full w-full rounded-xl object-cover" />
                                    @elseif (!empty($card['icon']))
                                        <span class="text-2xl">{{ $card['icon'] }}</span>
                                    @endif
                                </div>
                                <div>
                                    <h3 class="text-xs font-extrabold uppercase tracking-[0.12em]" style="color: var(--portal-accent)">{{ $card['label_' . $l] ?? '' }}</h3>
                                    <p class="mt-1 text-sm font-medium" style="color: var(--portal-text)">{{ $card['value_' . $l] ?? '' }}</p>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>

            @else
                {{-- Centered (default) --}}
                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-{{ min(count($items), 4) }}">
                    @foreach ($items as $card)
                        <div class="portal-stagger-item group flex flex-col items-center rounded-2xl p-8 text-center" style="background-color: var(--portal-card-bg); border: 1px solid color-mix(in srgb, var(--portal-text) 6%, transparent); box-shadow: 0 4px 15px rgba(0,0,0,0.04); transition: all 0.3s ease"
                             onmouseenter="this.style.transform='translateY(-8px)';this.style.boxShadow='0 25px 50px -12px rgba(0,0,0,0.15)'"
                             onmouseleave="this.style.transform='translateY(0)';this.style.boxShadow='0 4px 15px rgba(0,0,0,0.04)'">
                            <div class="mb-5 flex items-center justify-center overflow-hidden rounded-full shadow-inner transition-transform duration-300 group-hover:scale-110" style="width:5rem;height:5rem;min-width:5rem;min-height:5rem;background-color: color-mix(in srgb, var(--portal-accent) 8%, transparent)">
                                @if (!empty($card['image']))
                                    <img src="{{ Storage::disk('public')->url($card['image']) }}" alt="{{ $card['label_' . $l] ?? '' }}" class="h-full w-full rounded-full object-cover" />
                                @elseif (!empty($card['icon']))
                                    <span class="text-3xl">{{ $card['icon'] }}</span>
                                @else
                                    <svg class="size-9" style="color: color-mix(in srgb, var(--portal-text) 40%, transparent)" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                    </svg>
                                @endif
                            </div>
                            <h3 class="text-xs font-extrabold uppercase tracking-[0.15em]" style="color: var(--portal-text)">{{ $card['label_' . $l] ?? '' }}</h3>
                            <p class="mt-3 text-sm font-medium" style="color: color-mix(in srgb, var(--portal-text) 65%, transparent)">{{ $card['value_' . $l] ?? '' }}</p>
                        </div>
                    @endforeach
                </div>
            @endif

        </div>
    </section>
@endif
