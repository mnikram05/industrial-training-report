@php $d = $block['data']; @endphp
@if (!empty($d['url']))
    <section class="py-12">
        <div class="mx-auto max-w-3xl px-4 text-center sm:px-6 lg:px-8">
            <div class="text-white" style="background: linear-gradient(135deg, var(--portal-hero-from), var(--portal-hero-to)); border-radius: 15px; padding: 40px 30px">
                @if (!empty($d['text_' . $l]))
                    <p class="text-lg font-bold">{{ $d['text_' . $l] }}</p>
                @endif
                <a href="{{ $d['url'] }}" target="_blank" rel="noopener noreferrer"
                   class="mt-5 inline-block text-sm font-bold text-white transition-all duration-200 hover:opacity-90"
                   style="background-color: var(--portal-accent); padding: 12px 32px; border-radius: 20px; box-shadow: 0 4px 15px rgba(233, 69, 96, 0.4)">
                    {{ $d['button_text_' . $l] ?? ($l === 'ms' ? 'Layari Laman Web' : 'Visit Website') }}
                </a>
            </div>
        </div>
    </section>
@endif
