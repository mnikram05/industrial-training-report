@php $d = $block['data']; @endphp
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
            @if (!empty($d['text_' . $l]))
                <div class="text-sm leading-relaxed" style="color: var(--portal-text)">
                    {!! nl2br(e($d['text_' . $l])) !!}
                </div>
            @endif
        </div>
    </div>
</section>
