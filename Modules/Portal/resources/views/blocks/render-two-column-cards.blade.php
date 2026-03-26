@php $d = $block['data']; $cards = $d['cards'] ?? []; @endphp
@if (count($cards))
    <section class="py-8">
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
            @if (!empty($d['heading_' . $l]))
                <div class="mb-6 flex items-center gap-3">
                    @if (!empty($d['icon']))
                        <div class="flex size-10 items-center justify-center rounded-xl" style="background-color: color-mix(in srgb, var(--portal-accent) 15%, transparent)">
                            <span class="text-xl">{{ $d['icon'] }}</span>
                        </div>
                    @endif
                    <h2 class="text-xl font-bold" style="color: var(--portal-text)">{{ $d['heading_' . $l] }}</h2>
                </div>
            @endif
            <div class="grid gap-6 sm:grid-cols-2">
                @foreach ($cards as $card)
                    <div class="portal-stagger-item group transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl"
                         style="background-color: var(--portal-card-bg); border: 1px solid color-mix(in srgb, var(--portal-text) 10%, transparent); border-radius: 15px; padding: 30px 24px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03)">
                        <div class="text-center">
                            @if (!empty($card['icon']))
                                <div class="mb-3 text-4xl transition-transform duration-300 group-hover:scale-110">{{ $card['icon'] }}</div>
                            @endif
                            <h3 class="text-lg font-bold" style="color: var(--portal-text)">{{ $card['title_' . $l] ?? '' }}</h3>
                            <div class="mx-auto mt-2" style="width: 50px; height: 3px; background-color: var(--portal-accent); border-radius: 2px"></div>
                        </div>
                        @php $items = $card['items_' . $l] ?? []; @endphp
                        @if (is_array($items) && count($items))
                            <ul class="mt-5 space-y-2">
                                @foreach ($items as $item)
                                    <li class="flex items-start gap-2">
                                        <span class="mt-2 size-1.5 shrink-0 rounded-full" style="background-color: var(--portal-accent)"></span>
                                        <span class="text-sm leading-relaxed" style="color: var(--portal-text)">{{ $item }}</span>
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
