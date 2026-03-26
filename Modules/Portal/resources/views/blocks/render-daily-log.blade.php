@php $d = $block['data']; $days = $d['days'] ?? []; @endphp
@if (count($days))
    <section class="py-8">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
            <div class="overflow-hidden rounded-2xl border border-gray-100/50 shadow-lg" style="background-color: var(--portal-card-bg)">
                @if (!empty($d['heading_' . $l]))
                    <div class="flex items-center gap-3 px-6 py-4" style="background-color: var(--portal-card-bg)">
                        @if (!empty($d['icon']))
                            <span class="text-xl">{{ $d['icon'] }}</span>
                        @endif
                        <h3 class="text-lg font-black" style="color: var(--portal-text)">{{ $d['heading_' . $l] }}</h3>
                    </div>
                @endif
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
                            @foreach ($days as $day)
                                <tr class="border-b border-opacity-10 last:border-b-0">
                                    <td class="px-6 py-5 align-top text-sm font-bold" style="color: var(--portal-text)">
                                        {{ $day['day_' . $l] ?? $day['day_ms'] ?? '' }}
                                    </td>
                                    <td class="px-6 py-5 align-top">
                                        <ul class="list-disc space-y-1.5 pl-4">
                                            @foreach (($day['activities_' . $l] ?? $day['activities_ms'] ?? []) as $activity)
                                                <li class="text-sm" style="color: var(--portal-text)">{{ $activity }}</li>
                                            @endforeach
                                        </ul>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endif
