@php $d = $block['data']; @endphp
<section class="py-8">
    <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
        <div class="group transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl"
             style="background-color: #ffffff; border: 1px solid #f0f0f0; border-radius: 15px; padding: 24px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03)">
            @if (!empty($d['image_path']))
                <img src="{{ Storage::disk('public')->url($d['image_path']) }}"
                     alt="{{ $d['caption_' . $l] ?? '' }}"
                     class="mx-auto max-h-96 rounded-lg object-contain" />
            @else
                <div class="flex h-64 items-center justify-center rounded-lg bg-gray-100 text-gray-400">
                    <svg class="size-16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909M3.75 21h16.5A2.25 2.25 0 0 0 22.5 18.75V5.25A2.25 2.25 0 0 0 20.25 3H3.75A2.25 2.25 0 0 0 1.5 5.25v13.5A2.25 2.25 0 0 0 3.75 21Z"/>
                    </svg>
                </div>
            @endif
            @if (!empty($d['caption_' . $l]))
                <p class="mt-4 text-center text-sm font-semibold" style="color: #000000">{{ $d['caption_' . $l] }}</p>
            @endif
        </div>
    </div>
</section>
