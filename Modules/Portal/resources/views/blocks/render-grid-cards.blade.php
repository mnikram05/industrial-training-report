@php $d = $block['data']; $items = $d['items'] ?? []; @endphp
@if (count($items))
    <section class="py-8">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            @if (!empty($d['heading_' . $l]))
                <div class="mb-8 flex items-center gap-3">
                    @if (!empty($d['icon']))
                        <div class="flex size-10 items-center justify-center rounded-xl" style="background-color: color-mix(in srgb, var(--portal-accent) 15%, transparent); color: var(--portal-accent)">
                            <span class="text-xl">{{ $d['icon'] }}</span>
                        </div>
                    @endif
                    <h2 class="text-xl font-bold" style="color: var(--portal-text)">{{ $d['heading_' . $l] }}</h2>
                </div>
            @endif
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-{{ min(count($items), 4) }}">
                @foreach ($items as $item)
                    <div class="portal-stagger-item group flex flex-col items-center text-center transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl"
                         style="background-color: var(--portal-card-bg); border: 1px solid color-mix(in srgb, var(--portal-text) 10%, transparent); border-radius: 15px; padding: 24px 16px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03)">
                        @if (!empty($item['icon']))
                            <div class="mb-3 text-3xl transition-transform duration-300 group-hover:scale-110">{{ $item['icon'] }}</div>
                        @endif
                        <h3 class="mb-2 text-sm font-bold" style="color: var(--portal-text)">{{ $item['title_' . $l] ?? '' }}</h3>
                        @if (!empty($item['desc_' . $l]))
                            <p class="text-xs leading-relaxed" style="color: color-mix(in srgb, var(--portal-text) 65%, transparent)">{{ $item['desc_' . $l] }}</p>
                        @endif
                        @php $bullets = $item['bullets_' . $l] ?? []; @endphp
                        @if (is_array($bullets) && count($bullets))
                            <ul class="mt-3 w-full space-y-1.5 text-left">
                                @foreach ($bullets as $bullet)
                                    <li class="flex items-start gap-2">
                                        <span class="mt-2 size-1.5 shrink-0 rounded-full" style="background-color: var(--portal-accent)"></span>
                                        <span class="text-xs" style="color: var(--portal-text)">{{ $bullet }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif
