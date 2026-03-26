@php $l = app()->getLocale(); @endphp

<x-portal-layout :menuAtas="$menuAtas" :menuBawah="$menuBawah" :pageTitle="$siteTitle" portalPage="carta-organisasi">

    {{-- ===== Hero Section ===== --}}
    <section class="relative min-h-[250px] overflow-hidden flex items-center justify-center text-center text-white"
             style="background: linear-gradient(135deg, var(--portal-hero-from), var(--portal-hero-to)); padding: 40px 20px">
        <div class="absolute -left-32 -top-32 size-96 rounded-full opacity-[0.07] blur-3xl" style="background-color: var(--portal-accent)"></div>
        <div class="absolute -bottom-32 -right-32 size-96 rounded-full opacity-[0.07] blur-3xl" style="background-color: var(--portal-accent)"></div>
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_center,rgba(255,255,255,0.03)_0%,transparent_70%)]"></div>

        <div class="relative mx-auto max-w-4xl">
            <p class="animate-fade-in text-xs font-bold uppercase tracking-[0.3em] sm:text-sm" style="color: var(--portal-accent)">
                {{ $s['hero_subtitle_' . $l] ?? '' }}
            </p>
            <h1 class="mt-1 animate-fade-in text-3xl font-black uppercase tracking-tight drop-shadow-xl sm:text-4xl lg:text-5xl" style="animation-delay: 0.1s">
                {{ $s['hero_title_' . $l] ?? '' }}
            </h1>
            <div class="mx-auto animate-fade-in" style="width: 80px; height: 4px; background: linear-gradient(90deg, var(--portal-accent), #ff6b6b); margin: 12px auto; border-radius: 2px; animation-delay: 0.2s"></div>
        </div>
    </section>

    {{-- ===== Organization Chart Image ===== --}}
    <section class="relative -mt-8 py-12">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            <div class="transition-all duration-300 hover:-translate-y-[5px]"
                 style="background-color: #ffffff; border: 1px solid #f0f0f0; border-radius: 15px; padding: 24px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03)">
                @if (!empty($s['chart_image_path']))
                    <img src="{{ Storage::disk('public')->url($s['chart_image_path']) }}"
                         alt="{{ $s['chart_caption_' . $l] ?? '' }}"
                         class="w-full rounded-lg object-contain" />
                @else
                    <div class="flex h-64 items-center justify-center rounded-lg bg-gray-100 text-gray-400">
                        <svg class="size-16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909M3.75 21h16.5A2.25 2.25 0 0 0 22.5 18.75V5.25A2.25 2.25 0 0 0 20.25 3H3.75A2.25 2.25 0 0 0 1.5 5.25v13.5A2.25 2.25 0 0 0 3.75 21Z"/>
                        </svg>
                    </div>
                @endif
                @if (!empty($s['chart_caption_' . $l]))
                    <p class="mt-4 text-center text-sm font-semibold" style="color: #000000">
                        {{ $s['chart_caption_' . $l] }}
                    </p>
                @endif
            </div>
        </div>
    </section>

</x-portal-layout>
