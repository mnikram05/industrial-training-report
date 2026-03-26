@php
    $l = app()->getLocale();
    $visiItems = json_decode($s['visi_items_' . $l] ?? '[]', true) ?: [];
    $misiItems = json_decode($s['misi_items_' . $l] ?? '[]', true) ?: [];
@endphp

<x-portal-layout :menuAtas="$menuAtas" :menuBawah="$menuBawah" :pageTitle="$siteTitle" portalPage="visi-misi">

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

    {{-- ===== Visi & Misi Cards ===== --}}
    <section class="relative -mt-8 py-12">
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
            <div class="grid gap-6 sm:grid-cols-2">

                {{-- Visi --}}
                <div class="transition-all duration-300 hover:-translate-y-[5px]"
                     style="background-color: #ffffff; border: 1px solid #f0f0f0; border-radius: 15px; padding: 30px 24px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03)">
                    <div class="text-center">
                        @if (!empty($s['visi_icon']))
                            <div class="mb-3 text-4xl">{{ $s['visi_icon'] }}</div>
                        @endif
                        <h3 class="text-lg font-bold" style="color: #000000">
                            {{ $s['visi_title_' . $l] ?? ($l === 'ms' ? 'Visi Kami' : 'Our Vision') }}
                        </h3>
                        <div class="mx-auto mt-2" style="width: 50px; height: 3px; background-color: var(--portal-accent); border-radius: 2px"></div>
                    </div>
                    @if (count($visiItems))
                        <ul class="mt-5 space-y-2">
                            @foreach ($visiItems as $item)
                                <li class="flex items-start gap-2">
                                    <span class="mt-2 size-1.5 shrink-0 rounded-full" style="background-color: #000000"></span>
                                    <span class="text-sm leading-relaxed" style="color: #000000">{{ $item }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>

                {{-- Misi --}}
                <div class="transition-all duration-300 hover:-translate-y-[5px]"
                     style="background-color: #ffffff; border: 1px solid #f0f0f0; border-radius: 15px; padding: 30px 24px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03)">
                    <div class="text-center">
                        @if (!empty($s['misi_icon']))
                            <div class="mb-3 text-4xl">{{ $s['misi_icon'] }}</div>
                        @endif
                        <h3 class="text-lg font-bold" style="color: #000000">
                            {{ $s['misi_title_' . $l] ?? ($l === 'ms' ? 'Misi Kami' : 'Our Mission') }}
                        </h3>
                        <div class="mx-auto mt-2" style="width: 50px; height: 3px; background-color: var(--portal-accent); border-radius: 2px"></div>
                    </div>
                    @if (count($misiItems))
                        <ul class="mt-5 space-y-2">
                            @foreach ($misiItems as $item)
                                <li class="flex items-start gap-2">
                                    <span class="mt-2 size-1.5 shrink-0 rounded-full" style="background-color: #000000"></span>
                                    <span class="text-sm leading-relaxed" style="color: #000000">{{ $item }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>

            </div>
        </div>
    </section>

</x-portal-layout>
