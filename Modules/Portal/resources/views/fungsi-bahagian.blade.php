@php
    $l = app()->getLocale();
    $bahagianItems = json_decode($s['bahagian_items'] ?? '[]', true) ?: [];
@endphp

<x-portal-layout :menuAtas="$menuAtas" :menuBawah="$menuBawah" :pageTitle="$siteTitle" portalPage="fungsi-bahagian">

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

    {{-- ===== Fungsi Bahagian Cards ===== --}}
    @if (count($bahagianItems))
        <section class="relative -mt-8 py-12">
            <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
                <div class="grid gap-6 sm:grid-cols-2">
                    @foreach ($bahagianItems as $item)
                        <div class="transition-all duration-300 hover:-translate-y-[5px]"
                             style="background-color: #ffffff; border: 1px solid #f0f0f0; border-radius: 15px; padding: 24px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03)">
                            <div class="mb-3 flex items-center gap-2">
                                @if (!empty($item['icon']))
                                    <span class="text-xl">{{ $item['icon'] }}</span>
                                @endif
                                <h3 class="text-base font-bold" style="color: #000000">
                                    {{ $item['title_' . $l] ?? '' }}
                                </h3>
                            </div>
                            @if (!empty($item['desc_' . $l]))
                                <p class="mb-3 text-sm leading-relaxed" style="color: #555555">
                                    {{ $item['desc_' . $l] }}
                                </p>
                            @endif
                            @php $bullets = $item['bullets_' . $l] ?? []; @endphp
                            @if (is_array($bullets) && count($bullets))
                                <ul class="space-y-1.5">
                                    @foreach ($bullets as $bullet)
                                        <li class="flex items-start gap-2">
                                            <span class="mt-2 size-1.5 shrink-0 rounded-full" style="background-color: #000000"></span>
                                            <span class="text-sm" style="color: #000000">{{ $bullet }}</span>
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

</x-portal-layout>
