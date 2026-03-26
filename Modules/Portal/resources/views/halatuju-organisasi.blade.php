@php
    $l = app()->getLocale();
    $halatujuItems = json_decode($s['halatuju_items'] ?? '[]', true) ?: [];
@endphp

<x-portal-layout :menuAtas="$menuAtas" :menuBawah="$menuBawah" :pageTitle="$siteTitle" portalPage="halatuju-organisasi">

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

    {{-- ===== Halatuju Cards ===== --}}
    @if (count($halatujuItems))
        <section class="relative -mt-8 py-12">
            <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
                {{-- Section Header --}}
                <div class="mb-8 flex items-center gap-3">
                    <div class="flex size-10 items-center justify-center rounded-xl" style="background-color: rgba(233, 69, 96, 0.1); color: var(--portal-accent)">
                        <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold" style="color: #000000">
                        {{ $s['section_title_' . $l] ?? ($l === 'ms' ? 'Halatuju Organisasi' : 'Organisation Direction') }}
                    </h2>
                </div>

                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach ($halatujuItems as $item)
                        <div class="flex flex-col items-center text-center transition-all duration-300 hover:-translate-y-[5px]"
                             style="background-color: #ffffff; border: 1px solid #f0f0f0; border-radius: 15px; padding: 24px 16px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03)">
                            @if (!empty($item['icon']))
                                <div class="mb-3 text-3xl">{{ $item['icon'] }}</div>
                            @endif
                            <h3 class="mb-2 text-sm font-bold" style="color: #000000">
                                {{ $item['title_' . $l] ?? '' }}
                            </h3>
                            <p class="text-xs leading-relaxed" style="color: #666666">
                                {{ $item['desc_' . $l] ?? '' }}
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

</x-portal-layout>
