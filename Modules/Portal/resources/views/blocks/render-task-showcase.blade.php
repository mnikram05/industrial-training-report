@php $d = $block['data']; $items = $d['items'] ?? []; @endphp
@if (count($items))
    <section class="py-8">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            @if (!empty($d['heading_' . $l]))
                <div class="mb-8 flex items-center gap-3">
                    @if (!empty($d['icon']))
                        <div class="flex size-10 items-center justify-center rounded-xl transition-transform duration-300" style="background-color: rgba(233, 69, 96, 0.1); color: var(--portal-accent)">
                            <span class="text-xl">{{ $d['icon'] }}</span>
                        </div>
                    @endif
                    <h2 class="text-xl font-bold" style="color: #000000">{{ $d['heading_' . $l] }}</h2>
                </div>
            @endif

            <div class="space-y-8">
                @foreach ($items as $idx => $item)
                    <div class="group overflow-hidden transition-all duration-300 hover:-translate-y-1 hover:shadow-xl"
                         style="background-color: #ffffff; border: 1px solid #e8e8e8; border-radius: 16px; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05)">

                        {{-- Image Card --}}
                        @if (!empty($item['image']))
                            <div class="p-4 pb-0 sm:p-6 sm:pb-0">
                                <div class="overflow-hidden rounded-xl border border-gray-100" style="background-color: #fafafa">
                                    <img src="{{ Storage::disk('public')->url($item['image']) }}"
                                         alt="{{ $item['title_' . $l] ?? '' }}"
                                         class="max-h-[28rem] w-full object-contain" />
                                </div>
                                @if (!empty($item['image_label_' . $l]))
                                    <p class="mt-3 text-center text-xs italic text-gray-400">{{ $item['image_label_' . $l] }}</p>
                                @endif
                            </div>
                        @endif

                        {{-- Divider --}}
                        @if (!empty($item['image']))
                            <div class="mx-6 mt-5 border-t border-gray-100 sm:mx-8"></div>
                        @endif

                        {{-- Content --}}
                        <div class="p-6 pt-5 md:p-8 md:pt-6">
                            @if (!empty($item['title_' . $l]))
                                <h3 class="mb-3 text-lg font-black" style="color: #000000">
                                    {{ $item['title_' . $l] }}
                                </h3>
                            @endif
                            @if (!empty($item['desc_' . $l]))
                                <div class="text-sm leading-relaxed" style="color: #444444">
                                    {!! nl2br(e($item['desc_' . $l])) !!}
                                </div>
                            @endif
                            @php $bullets = $item['bullets_' . $l] ?? []; @endphp
                            @if (is_array($bullets) && count($bullets))
                                <ul class="mt-4 space-y-2">
                                    @foreach ($bullets as $bullet)
                                        <li class="flex items-start gap-2">
                                            <span class="mt-2 size-1.5 shrink-0 rounded-full" style="background-color: var(--portal-accent)"></span>
                                            <span class="text-sm" style="color: #000000">{{ $bullet }}</span>
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
