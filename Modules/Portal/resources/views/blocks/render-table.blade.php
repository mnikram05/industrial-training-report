@php $d = $block['data']; $rows = $d['rows'] ?? []; @endphp
@if (count($rows))
    <section class="py-8">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
            <div class="transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl" style="background-color: var(--portal-card-bg); border-radius: 15px; overflow: hidden; border: 1px solid color-mix(in srgb, var(--portal-text) 10%, transparent); box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03)">
                @if (!empty($d['heading_' . $l]))
                    <div style="background-color: var(--portal-header-bg); padding: 16px 24px">
                        <h3 class="text-center text-lg font-bold text-white">{{ $d['heading_' . $l] }}</h3>
                    </div>
                @endif
                <div class="overflow-x-auto">
                    <table class="w-full" style="border-collapse: collapse">
                        <thead style="background-color: color-mix(in srgb, var(--portal-text) 5%, transparent); border-bottom: 2px solid color-mix(in srgb, var(--portal-text) 15%, transparent)">
                            <tr>
                                @foreach ($d['columns_' . $l] ?? [($l === 'ms' ? 'Hari' : 'Day'), ($l === 'ms' ? 'Waktu Bekerja' : 'Working Hours'), ($l === 'ms' ? 'Waktu Rehat' : 'Break Time')] as $col)
                                    <th style="padding: 20px; border: 1px solid color-mix(in srgb, var(--portal-text) 15%, transparent); text-align: left; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: color-mix(in srgb, var(--portal-text) 55%, transparent)">
                                        {{ $col }}
                                    </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rows as $row)
                                <tr>
                                    @foreach ($row as $key => $cell)
                                        <td style="padding: 20px; border: 1px solid color-mix(in srgb, var(--portal-text) 15%, transparent); color: var(--portal-text)">{{ $cell }}</td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endif
