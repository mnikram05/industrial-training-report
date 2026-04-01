@php
    $d = $block['data'];
    $items = $d['items'] ?? [];
@endphp
@if (count($items))
    <section class="py-8">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            <div class="group transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl"
                 style="background-color: var(--portal-card-bg); border: 1px solid color-mix(in srgb, var(--portal-text) 10%, transparent); border-radius: 15px; padding: 24px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03)">
                @if (!empty($d['heading_' . $l]))
                    <div class="mb-4 flex items-center gap-3">
                        @if (!empty($d['icon']))
                            <div class="flex size-10 items-center justify-center rounded-xl transition-transform duration-300 group-hover:scale-110" style="background-color: color-mix(in srgb, var(--portal-accent) 15%, transparent)">
                                <span class="text-xl">{{ $d['icon'] }}</span>
                            </div>
                        @endif
                        <h3 class="text-lg font-bold" style="color: var(--portal-text)">{{ $d['heading_' . $l] }}</h3>
                    </div>
                @endif
                <ul class="space-y-3">
                    @foreach ($items as $item)
                        @php
                            $url = $item['url'] ?? '#';
                            $label = $item['label_' . $l] ?? $url;
                        @endphp
                        <li>
                            <a href="{{ $url }}" target="_blank" rel="noopener noreferrer"
                               class="break-words text-sm font-medium underline decoration-2 underline-offset-2 transition-colors hover:opacity-90"
                               style="color: var(--portal-accent)">{{ $label }}</a>
                            @if (! empty($item['label_' . $l]) && $url !== $item['label_' . $l])
                                <p class="mt-1 break-all text-xs opacity-60" style="color: var(--portal-text)">{{ $url }}</p>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </section>
@endif
