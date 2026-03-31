@php
    $d = $block['data'];

    $c = function(string $key, string $fallback = 'var(--portal-text)') use ($d): string {
        return !empty($d[$key]) ? $d[$key] : $fallback;
    };
@endphp

<style>
    html.dark-portal .wg-title    { color: var(--wg-title-dark)    !important; }
    html.dark-portal .wg-topic    { color: var(--wg-topic-dark)    !important; }
    html.dark-portal .wg-rh      { color: var(--wg-rh-dark)       !important; }
    html.dark-portal .wg-day     { color: var(--wg-day-dark)      !important; }
    html.dark-portal .wg-act     { color: var(--wg-act-dark)      !important; }
</style>

<section class="py-10">
    <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
        <div class="rounded-2xl border border-gray-100/50 p-6 shadow-lg" style="background-color: var(--portal-card-bg)">
            @if (!empty($d['heading_' . $l]))
                <h2 class="mb-6 text-xl font-black" style="color: var(--portal-text)">{{ $d['heading_' . $l] }}</h2>
            @endif

            <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-4">
                @foreach (($d['items'] ?? []) as $idx => $item)
                    @php
                        $dateLabel = '';
                        if (!empty($item['start_date']) && !empty($item['end_date'])) {
                            $dateLabel = strtoupper(\Carbon\Carbon::parse($item['start_date'])->translatedFormat('j M')) . ' - ' . strtoupper(\Carbon\Carbon::parse($item['end_date'])->translatedFormat('j M Y'));
                        }
                        $hasContent = !empty($item['days']) || !empty($item['reflection_' . $l]);
                    @endphp
                    @if ($hasContent)
                        <a href="#minggu-{{ $idx + 1 }}"
                    @else
                        <div
                    @endif
                        class="week-card group rounded-xl border-2 p-4 text-center transition-all duration-300 hover:-translate-y-2 hover:scale-[1.03] hover:shadow-2xl"
                        style="border-color: color-mix(in srgb, var(--portal-accent) 30%, transparent)"
                        onmouseenter="this.style.backgroundColor='var(--portal-accent)';this.style.borderColor='var(--portal-accent)';this.querySelector('.week-title').style.color='#fff';var d=this.querySelector('.week-date');if(d)d.style.color='rgba(255,255,255,0.8)'"
                        onmouseleave="this.style.backgroundColor='';this.style.borderColor='color-mix(in srgb, var(--portal-accent) 30%, transparent)';this.querySelector('.week-title').style.color='var(--portal-accent)';var d=this.querySelector('.week-date');if(d)d.style.color='color-mix(in srgb, var(--portal-accent) 70%, transparent)'"
                    >
                        <p class="week-title text-sm font-black transition-colors duration-300" style="color: var(--portal-accent)">
                            {{ $item['title_' . $l] ?? $item['title_ms'] ?? '' }}
                        </p>
                        @if ($dateLabel)
                            <p class="week-date mt-1 text-xs font-medium transition-colors duration-300" style="color: color-mix(in srgb, var(--portal-accent) 70%, transparent)">
                                {{ $dateLabel }}
                            </p>
                        @endif
                    @if ($hasContent)
                        </a>
                    @else
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- Render each week's detail section --}}
@foreach (($d['items'] ?? []) as $idx => $item)
    @if (!empty($item['days']) || !empty($item['reflection_' . $l]))
        <section class="pt-2 pb-8">
            <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">

                @php
                    $titleL  = $c('title_color', 'var(--portal-text)');
                    $titleD  = $c('title_color_dark', $titleL);
                    $topicL  = $c('topic_color', 'var(--portal-accent)');
                    $topicD  = $c('topic_color_dark', $topicL);
                    $rhL     = $c('report_heading_color', 'var(--portal-text)');
                    $rhD     = $c('report_heading_color_dark', $rhL);
                    $dayL    = $c('day_color', 'var(--portal-text)');
                    $dayD    = $c('day_color_dark', $dayL);
                    $actL    = $c('activity_color', 'var(--portal-text)');
                    $actD    = $c('activity_color_dark', $actL);
                @endphp

                {{-- Week title --}}
                <h2 id="minggu-{{ $idx + 1 }}" class="mb-4 text-2xl font-black wg-title"
                    style="--wg-title-dark: {{ $titleD }}; color: {{ $titleL }}; scroll-margin-top: 5rem">
                    {{ $item['title_' . $l] ?? $item['title_ms'] ?? '' }}
                    @if (!empty($item['start_date']) && !empty($item['end_date']))
                        <span class="ml-2 text-base font-medium text-gray-400">
                            {{ \Carbon\Carbon::parse($item['start_date'])->translatedFormat('j M') }} – {{ \Carbon\Carbon::parse($item['end_date'])->translatedFormat('j M Y') }}
                        </span>
                    @endif
                </h2>

                {{-- Week Topic --}}
                @if (!empty($item['topic_' . $l]))
                    <p class="mb-4 text-sm font-semibold uppercase tracking-wide wg-topic"
                        style="--wg-topic-dark: {{ $topicD }}; color: {{ $topicL }}">
                        {{ $item['topic_' . $l] }}
                    </p>
                @endif

                {{-- Daily Log Table --}}
                @if (!empty($item['days']))
                    <div class="overflow-hidden rounded-2xl border border-gray-100/50 shadow-lg transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl" style="background-color: var(--portal-card-bg)">
                        <div class="flex items-center gap-3 px-6 py-4">
                            <span class="text-xl">📅</span>
                            <h3 class="wg-rh text-lg font-black" style="--wg-rh-dark: {{ $rhD }}; color: {{ $rhL }}">
                                {{ $l === 'ms' ? 'LAPORAN AKTIVITI HARIAN' : 'DAILY ACTIVITY REPORT' }}
                            </h3>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full" style="border-collapse: collapse">
                                <thead>
                                    <tr style="background-color: color-mix(in srgb, var(--portal-text) 3%, transparent)">
                                        <th class="w-28 border-b px-6 py-4 text-left text-xs font-bold uppercase tracking-wide opacity-50">
                                            {{ $l === 'ms' ? 'Hari' : 'Day' }}
                                        </th>
                                        <th class="border-b px-6 py-4 text-left text-xs font-bold uppercase tracking-wide opacity-50">
                                            {{ $l === 'ms' ? 'Ringkasan Aktiviti / Tugas' : 'Activity Summary / Tasks' }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($item['days'] as $day)
                                        <tr class="border-b border-opacity-10 last:border-b-0">
                                            <td class="wg-day px-6 py-5 align-top text-sm font-bold"
                                                style="--wg-day-dark: {{ $dayD }}; color: {{ $dayL }}">
                                                {{ $day['day_' . $l] ?? $day['day_ms'] ?? '' }}
                                            </td>
                                            <td class="px-6 py-5 align-top">
                                                <ul class="list-disc space-y-1.5 pl-4">
                                                    @foreach (($day['activities_' . $l] ?? $day['activities_ms'] ?? []) as $activity)
                                                        <li class="wg-act text-sm"
                                                            style="--wg-act-dark: {{ $actD }}; color: {{ $actL }}">{{ $activity }}</li>
                                                    @endforeach
                                                </ul>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif

                {{-- Reflection --}}
                @if (!empty($item['reflection_' . $l]))
                    <div class="mt-6 rounded-2xl border border-gray-100/50 p-6 shadow-lg transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl" style="background-color: var(--portal-card-bg)">
                        <div class="mb-4 flex items-center gap-3">
                            <span class="text-xl">💭</span>
                            <h3 class="text-lg font-black" style="color: var(--portal-text)">
                                {{ $l === 'ms' ? 'REFLEKSI MINGGUAN' : 'WEEKLY REFLECTION' }}
                            </h3>
                        </div>
                        <div class="text-sm leading-relaxed" style="color: var(--portal-text)">
                            {!! nl2br(e($item['reflection_' . $l])) !!}
                        </div>
                    </div>
                @endif

            </div>
        </section>
    @endif
@endforeach
