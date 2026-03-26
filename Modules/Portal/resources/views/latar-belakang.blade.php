@php
    $l = app()->getLocale();

    $objektifItems = json_decode($s['objektif_items_' . $l] ?? '[]', true) ?: [];
    $nilaiItems    = json_decode($s['nilai_utama_items_' . $l] ?? '[]', true) ?: [];
    $komitmenItems = json_decode($s['komitmen_items_' . $l] ?? '[]', true) ?: [];
    $wargaItems    = json_decode($s['warga_kerja_items_' . $l] ?? '[]', true) ?: [];
    $jadualData    = json_decode($s['jadual_data'] ?? '[]', true) ?: [];
    $aktivitiItems = json_decode($s['aktiviti_items'] ?? '[]', true) ?: [];
@endphp

<x-portal-layout :menuAtas="$menuAtas" :menuBawah="$menuBawah" :pageTitle="$siteTitle" portalPage="latar-belakang">

    {{-- ===== 1. Hero Section ===== --}}
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
            {{-- red-line: 80px, 4px, gradient accent → #ff6b6b, margin 12px auto --}}
            <div class="mx-auto animate-fade-in" style="width: 80px; height: 4px; background: linear-gradient(90deg, var(--portal-accent), #ff6b6b); margin: 12px auto; border-radius: 2px; animation-delay: 0.2s"></div>
            @if (!empty($s['hero_address']))
                <p class="mt-4 animate-fade-in flex items-center justify-center gap-2 text-sm tracking-wide text-gray-400" style="animation-delay: 0.3s">
                    <svg class="size-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z"/>
                    </svg>
                    {{ $s['hero_address'] }}
                </p>
            @endif
        </div>
    </section>

    {{-- ===== 2. Two Image Cards (section-card style) ===== --}}
    <section class="relative -mt-8 py-12">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
            <div class="grid gap-6 sm:grid-cols-2">
                {{-- Logo Image --}}
                <div class="flex flex-col items-center transition-all duration-300 hover:-translate-y-[5px]"
                     style="background-color: #ffffff; border: 1px solid #f0f0f0; border-radius: 15px; padding: 16px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03)">
                    <div class="flex flex-1 items-center justify-center">
                        @if (!empty($s['logo_image_path']))
                            <img src="{{ Storage::disk('public')->url($s['logo_image_path']) }}"
                                 alt="{{ $s['logo_caption_' . $l] ?? '' }}"
                                 class="max-h-40 rounded-lg object-contain" />
                        @else
                            <div class="flex h-32 items-center justify-center rounded-lg bg-gray-100 text-gray-400">
                                <svg class="size-12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1"><path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909M3.75 21h16.5A2.25 2.25 0 0 0 22.5 18.75V5.25A2.25 2.25 0 0 0 20.25 3H3.75A2.25 2.25 0 0 0 1.5 5.25v13.5A2.25 2.25 0 0 0 3.75 21Z"/></svg>
                            </div>
                        @endif
                    </div>
                    @if (!empty($s['logo_caption_' . $l]))
                        <p class="mt-auto pt-2 text-center text-xs font-semibold" style="color: #000000">{{ $s['logo_caption_' . $l] }}</p>
                    @endif
                </div>

                {{-- Lokasi / Map Image --}}
                <div class="flex flex-col items-center transition-all duration-300 hover:-translate-y-[5px]"
                     style="background-color: #ffffff; border: 1px solid #f0f0f0; border-radius: 15px; padding: 16px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03)">
                    <div class="flex flex-1 items-center justify-center">
                        @if (!empty($s['lokasi_image_path']))
                            <img src="{{ Storage::disk('public')->url($s['lokasi_image_path']) }}"
                                 alt="{{ $s['lokasi_caption_' . $l] ?? '' }}"
                                 class="max-h-40 rounded-lg object-contain" />
                        @else
                            <div class="flex h-32 items-center justify-center rounded-lg bg-gray-100 text-gray-400">
                                <svg class="size-12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1"><path stroke-linecap="round" stroke-linejoin="round" d="M9 6.75V15m6-6v8.25m.503 3.498 4.875-2.437c.381-.19.622-.58.622-1.006V4.82c0-.836-.88-1.38-1.628-1.006l-3.869 1.934c-.317.159-.69.159-1.006 0L9.503 3.252a1.125 1.125 0 0 0-1.006 0L3.622 5.689C3.24 5.88 3 6.27 3 6.695V19.18c0 .836.88 1.38 1.628 1.006l3.869-1.934c.317-.159.69-.159 1.006 0l4.994 2.497c.317.158.69.158 1.006 0Z"/></svg>
                            </div>
                        @endif
                    </div>
                    @if (!empty($s['lokasi_caption_' . $l]))
                        <p class="mt-auto pt-2 text-center text-xs font-semibold" style="color: #000000">{{ $s['lokasi_caption_' . $l] }}</p>
                    @endif
                </div>
            </div>
        </div>
    </section>

    {{-- ===== 3. Two Content Cards (Latar Belakang + Objektif) — section-card style ===== --}}
    <section class="py-8">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            <div class="grid gap-6 lg:grid-cols-2">
                {{-- Latar Belakang Syarikat --}}
                <div class="transition-all duration-300 hover:-translate-y-[5px]"
                     style="background-color: #ffffff; border: 1px solid #f0f0f0; border-radius: 15px; padding: 20px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03)">
                    <div class="mb-4 flex items-center gap-3">
                        <div class="flex size-10 items-center justify-center rounded-xl" style="background-color: rgba(233, 69, 96, 0.1); color: var(--portal-accent)">
                            <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold" style="color: #000000">
                            {{ $s['latar_belakang_title_' . $l] ?? ($l === 'ms' ? 'Latar Belakang Syarikat' : 'Company Background') }}
                        </h3>
                    </div>
                    <div class="text-sm leading-relaxed" style="color: #000000">
                        {!! nl2br(e($s['latar_belakang_text_' . $l] ?? '')) !!}
                    </div>
                </div>

                {{-- Objektif Strategik --}}
                <div class="transition-all duration-300 hover:-translate-y-[5px]"
                     style="background-color: #ffffff; border: 1px solid #f0f0f0; border-radius: 15px; padding: 20px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03)">
                    <div class="mb-4 flex items-center gap-3">
                        <div class="flex size-10 items-center justify-center rounded-xl" style="background-color: rgba(233, 69, 96, 0.1); color: var(--portal-accent)">
                            <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold" style="color: #000000">
                            {{ $s['objektif_title_' . $l] ?? ($l === 'ms' ? 'Objektif Strategik' : 'Strategic Objectives') }}
                        </h3>
                    </div>
                    @if (count($objektifItems))
                        <ul class="space-y-3">
                            @foreach ($objektifItems as $item)
                                <li class="flex items-start gap-3">
                                    <span class="mt-0.5 flex size-5 shrink-0 items-center justify-center" style="color: var(--portal-accent)">&#10003;</span>
                                    <span class="text-sm" style="color: #000000">{{ $item }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </section>

    {{-- ===== 4. Three Value Cards — section-card style ===== --}}
    <section class="py-8">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            <div class="grid gap-6 sm:grid-cols-3">
                @php
                    $valueCards = [
                        [
                            'title' => $s['nilai_utama_title_' . $l] ?? ($l === 'ms' ? 'Nilai Utama' : 'Core Values'),
                            'items' => $nilaiItems,
                            'icon'  => 'M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z',
                        ],
                        [
                            'title' => $s['komitmen_title_' . $l] ?? ($l === 'ms' ? 'Komitmen Pelanggan' : 'Customer Commitment'),
                            'items' => $komitmenItems,
                            'icon'  => 'M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z',
                        ],
                        [
                            'title' => $s['warga_kerja_title_' . $l] ?? ($l === 'ms' ? 'Warga Kerja' : 'Workforce'),
                            'items' => $wargaItems,
                            'icon'  => 'M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z',
                        ],
                    ];
                @endphp

                @foreach ($valueCards as $card)
                    <div class="transition-all duration-300 hover:-translate-y-[5px]"
                         style="background-color: #ffffff; border: 1px solid #f0f0f0; border-radius: 15px; padding: 20px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03)">
                        <div class="mb-4 flex items-center gap-3">
                            <div class="flex size-10 items-center justify-center rounded-xl" style="background-color: rgba(233, 69, 96, 0.1); color: var(--portal-accent)">
                                <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="{{ $card['icon'] }}"/>
                                </svg>
                            </div>
                            <h3 class="text-base font-bold" style="color: #000000">{{ $card['title'] }}</h3>
                        </div>
                        @if (count($card['items']))
                            <ul class="space-y-2">
                                @foreach ($card['items'] as $bullet)
                                    <li class="flex items-start gap-2">
                                        <span class="mt-1.5 size-1.5 shrink-0 rounded-full" style="background-color: var(--portal-accent)"></span>
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

    {{-- ===== 5. Working Hours Table — .table style (dark header #1a1a2e, #dee2e6 borders) ===== --}}
    @if (count($jadualData))
        <section class="py-8">
            <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
                <div style="background-color: #ffffff; border-radius: 15px; overflow: hidden; border: 1px solid #dee2e6; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03)">
                    <div style="background-color: #1a1a2e; padding: 16px 24px">
                        <h3 class="text-center text-lg font-bold text-white">
                            {{ $s['jadual_title_' . $l] ?? ($l === 'ms' ? 'Jadual Waktu Bekerja' : 'Working Hours Schedule') }}
                        </h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full" style="border-collapse: collapse">
                            <thead style="background-color: #f8f9fa; border-bottom: 2px solid #dee2e6">
                                <tr>
                                    <th style="padding: 20px; border: 1px solid #dee2e6; text-align: left; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #636e72">
                                        {{ $l === 'ms' ? 'Hari' : 'Day' }}
                                    </th>
                                    <th style="padding: 20px; border: 1px solid #dee2e6; text-align: left; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #636e72">
                                        {{ $l === 'ms' ? 'Waktu Bekerja' : 'Working Hours' }}
                                    </th>
                                    <th style="padding: 20px; border: 1px solid #dee2e6; text-align: left; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #636e72">
                                        {{ $l === 'ms' ? 'Waktu Rehat' : 'Break Time' }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($jadualData as $row)
                                    <tr>
                                        <td style="padding: 20px; border: 1px solid #dee2e6; color: #000000; font-weight: 500">{{ $row['hari_' . $l] ?? $row['hari'] ?? '' }}</td>
                                        <td style="padding: 20px; border: 1px solid #dee2e6; color: #000000">{{ $row['waktu_bekerja'] ?? '' }}</td>
                                        <td style="padding: 20px; border: 1px solid #dee2e6; color: #000000">{{ $row['waktu_rehat'] ?? '' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    @endif

    {{-- ===== 6. Aktiviti Utama — satu gambar yang mewakili semua aktiviti ===== --}}
    @if (!empty($s['aktiviti_image_path']))
        <section class="py-8">
            <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
                @if (!empty($s['aktiviti_caption_' . $l]))
                    <h2 class="mb-6 text-xl font-bold" style="color: #000000">{{ $s['aktiviti_caption_' . $l] }}</h2>
                @endif
                <img src="{{ Storage::disk('public')->url($s['aktiviti_image_path']) }}"
                     alt="{{ $s['aktiviti_caption_' . $l] ?? '' }}"
                     class="w-full rounded-[15px] object-contain" />
            </div>
        </section>
    @endif

    {{-- ===== 7. CTA Section ===== --}}
    @if (!empty($s['cta_url']))
        <section class="py-12">
            <div class="mx-auto max-w-3xl px-4 text-center sm:px-6 lg:px-8">
                <div class="text-white" style="background: linear-gradient(135deg, var(--portal-hero-from), var(--portal-hero-to)); border-radius: 15px; padding: 40px 30px">
                    <p class="text-lg font-bold">{{ $s['cta_text_' . $l] ?? '' }}</p>
                    <a href="{{ $s['cta_url'] }}" target="_blank" rel="noopener noreferrer"
                       class="mt-5 inline-block text-sm font-bold text-white transition-all duration-200 hover:opacity-90"
                       style="background-color: var(--portal-accent); padding: 12px 32px; border-radius: 20px; box-shadow: 0 4px 15px rgba(233, 69, 96, 0.4)">
                        {{ $s['cta_button_text_' . $l] ?? ($l === 'ms' ? 'Layari Laman Web' : 'Visit Website') }}
                    </a>
                </div>
            </div>
        </section>
    @endif

</x-portal-layout>
