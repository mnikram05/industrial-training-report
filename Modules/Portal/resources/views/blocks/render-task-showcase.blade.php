@php $d = $block['data']; $items = $d['items'] ?? []; @endphp
@if (count($items))
    <section class="py-8">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            @if (!empty($d['heading_' . $l]))
                <div class="mb-8 flex items-center gap-3">
                    @if (!empty($d['icon']))
                        <div class="flex size-10 items-center justify-center rounded-xl transition-transform duration-300" style="background-color: color-mix(in srgb, var(--portal-accent) 15%, transparent); color: var(--portal-accent)">
                            <span class="text-xl">{{ $d['icon'] }}</span>
                        </div>
                    @endif
                    <h2 class="text-xl font-bold" style="color: var(--portal-text)">{{ $d['heading_' . $l] }}</h2>
                </div>
            @endif

            <div class="space-y-8">
                @foreach ($items as $idx => $item)
                    <div class="group overflow-hidden transition-all duration-300 hover:-translate-y-1 hover:shadow-xl"
                         style="background-color: var(--portal-card-bg); border: 1px solid color-mix(in srgb, var(--portal-text) 10%, transparent); border-radius: 16px; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05)">

                        {{-- Image Card --}}
                        @if (!empty($item['image']))
                            <div class="p-4 pb-0 sm:p-6 sm:pb-0">
                                <div class="overflow-hidden rounded-xl" style="border: 1px solid color-mix(in srgb, var(--portal-text) 8%, transparent); background-color: color-mix(in srgb, var(--portal-text) 3%, transparent)">
                                    <img src="{{ Storage::disk('public')->url($item['image']) }}"
                                         alt="{{ $item['title_' . $l] ?? '' }}"
                                         class="max-h-[28rem] w-full object-contain" />
                                </div>
                                @if (!empty($item['image_label_' . $l]))
                                    <p class="mt-3 text-center text-xs italic" style="color: color-mix(in srgb, var(--portal-text) 50%, transparent)">{{ $item['image_label_' . $l] }}</p>
                                @endif
                            </div>
                        @endif

                        {{-- Divider --}}
                        @if (!empty($item['image']))
                            <div class="mx-6 mt-5 sm:mx-8" style="border-top: 1px solid color-mix(in srgb, var(--portal-text) 8%, transparent)"></div>
                        @endif

                        {{-- Content --}}
                        <div class="p-6 pt-5 md:p-8 md:pt-6">
                            @if (!empty($item['title_' . $l]))
                                <h3 class="mb-3 text-lg font-black" style="color: var(--portal-text)">
                                    {{ $item['title_' . $l] }}
                                </h3>
                            @endif
                            @if (!empty($item['desc_' . $l]))
                                <div class="text-sm leading-relaxed" style="color: color-mix(in srgb, var(--portal-text) 75%, transparent)">
                                    {!! nl2br(e($item['desc_' . $l])) !!}
                                </div>
                            @endif
                            @php $bullets = $item['bullets_' . $l] ?? []; @endphp
                            @if (is_array($bullets) && count($bullets))
                                <ul class="mt-4 space-y-2">
                                    @foreach ($bullets as $bullet)
                                        <li class="flex items-start gap-2">
                                            <span class="mt-2 size-1.5 shrink-0 rounded-full" style="background-color: var(--portal-accent)"></span>
                                            <span class="text-sm" style="color: var(--portal-text)">{{ $bullet }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif
