@php $d = $block['data']; @endphp

<section class="relative -mt-8 py-12">
    <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
        <div class="grid gap-6 lg:grid-cols-5">

            {{-- Left Column: Profile Card --}}
            <div class="lg:col-span-2">
                <div class="rounded-2xl border border-gray-100/50 p-5 text-center shadow-lg" style="background-color: var(--portal-card-bg)">
                    {{-- Profile Photo --}}
                    <div class="relative mx-auto mb-2 size-20">
                        @if (!empty($d['photo_path']))
                            <img src="{{ Storage::disk('public')->url($d['photo_path']) }}" alt="{{ $d['nama'] ?? '' }}"
                                class="size-20 rounded-full border-4 border-gray-100 object-cover shadow-md" />
                        @else
                            <div class="flex size-20 items-center justify-center rounded-full border-4 border-gray-100 bg-gradient-to-br from-gray-100 to-gray-200 shadow-md">
                                <svg class="size-20 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                </svg>
                            </div>
                        @endif
                        <span class="absolute bottom-1 right-3 size-4 rounded-full border-2 border-white bg-green-500 shadow"></span>
                    </div>

                    {{-- Name --}}
                    <h2 class="text-lg font-bold" style="color: var(--portal-text)">{{ $d['nama'] ?? '' }}</h2>

                    {{-- Student ID Badge --}}
                    @if (!empty($d['no_pelajar']))
                        <span class="mt-2 inline-block rounded-full border border-red-200 bg-red-50 px-4 py-1 text-xs font-bold tracking-wide text-red-500">
                            {{ $d['no_pelajar'] }}
                        </span>
                    @endif

                    {{-- Program --}}
                    @if (!empty($d['program_' . $l]) || !empty($d['program']))
                        <p class="mt-3 text-sm text-gray-500">{{ $d['program_' . $l] ?? $d['program'] ?? '' }}</p>
                    @endif
                </div>

                {{-- Internship Period Card --}}
                @if (!empty($d['tempoh_li']))
                    <div class="mt-4 rounded-2xl border border-gray-100/50 p-6 shadow-lg" style="background-color: var(--portal-card-bg)">
                        <p class="text-xs font-bold uppercase tracking-wide" style="color: var(--portal-text)">
                            {{ $l === 'ms' ? 'Tempoh LI' : 'Internship Period' }}
                        </p>
                        <p class="mt-1 text-sm font-semibold" style="color: var(--portal-text)">{{ $d['tempoh_li'] }}</p>
                    </div>
                @endif
            </div>

            {{-- Right Column --}}
            <div class="space-y-6 lg:col-span-3">

                {{-- Maklumat Akademik Card --}}
                <div class="rounded-2xl border border-gray-100/50 p-6 shadow-lg" style="background-color: var(--portal-card-bg)">
                    <div class="mb-5 flex items-center gap-3">
                        <div class="flex size-10 items-center justify-center rounded-xl bg-blue-50 text-blue-500">
                            <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a23.54 23.54 0 0 0-2.688 11.354 23.54 23.54 0 0 1 7.17-2.583M4.26 10.147A23.46 23.46 0 0 1 12 8.243a23.46 23.46 0 0 1 7.74 1.904m0 0 .502 1.646a48.357 48.357 0 0 1 3.508 1.05M19.74 10.147a23.54 23.54 0 0 1 2.688 11.354M14.25 2.75a2.25 2.25 0 0 0-4.5 0v.5h4.5v-.5Z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold" style="color: var(--portal-text)">
                            {{ $l === 'ms' ? 'Maklumat Akademik' : 'Academic Information' }}
                        </h3>
                    </div>

                    <div class="grid gap-6 sm:grid-cols-2">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-wide text-gray-400">
                                {{ $l === 'ms' ? 'Program Pengajian' : 'Study Programme' }}
                            </p>
                            <p class="mt-1 text-sm font-medium" style="color: var(--portal-text)">{{ $d['program_' . $l] ?? $d['program'] ?? '' }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-bold uppercase tracking-wide text-gray-400">
                                {{ $l === 'ms' ? 'Sesi Latihan' : 'Training Session' }}
                            </p>
                            <p class="mt-1 text-sm font-medium" style="color: var(--portal-text)">{{ $d['sesi_latihan'] ?? '' }}</p>
                        </div>
                    </div>
                </div>

                {{-- Biodata Card --}}
                <div class="rounded-2xl border border-gray-100/50 p-6 shadow-lg" style="background-color: var(--portal-card-bg)">
                    <div class="mb-5 flex items-center gap-3">
                        <div class="flex size-10 items-center justify-center rounded-xl bg-pink-50 text-pink-500">
                            <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Zm6-10.125a1.875 1.875 0 1 1-3.75 0 1.875 1.875 0 0 1 3.75 0Zm1.294 6.336a6.721 6.721 0 0 1-3.17.789 6.721 6.721 0 0 1-3.168-.789 3.376 3.376 0 0 1 6.338 0Z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold" style="color: var(--portal-text)">Biodata</h3>
                    </div>

                    <div class="space-y-5">
                        @php
                            $biodataItems = [
                                [
                                    'label' => $l === 'ms' ? 'Tarikh Lahir' : 'Date of Birth',
                                    'value' => $d['tarikh_lahir'] ?? '',
                                    'icon' => 'M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5',
                                ],
                                [
                                    'label' => $l === 'ms' ? 'Nombor Telefon' : 'Phone Number',
                                    'value' => $d['telefon'] ?? '',
                                    'icon' => 'M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z',
                                ],
                                [
                                    'label' => 'Email',
                                    'value' => $d['email'] ?? '',
                                    'icon' => 'M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75',
                                    'is_email' => true,
                                ],
                                [
                                    'label' => $l === 'ms' ? 'Alamat' : 'Address',
                                    'value' => $d['alamat'] ?? '',
                                    'icon' => 'M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z',
                                ],
                            ];
                        @endphp

                        @foreach ($biodataItems as $item)
                            @if (!empty($item['value']))
                                <div class="flex items-start gap-4">
                                    <div class="flex size-10 shrink-0 items-center justify-center rounded-xl bg-gray-50 text-gray-400">
                                        <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] }}" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-xs font-semibold text-gray-400">{{ $item['label'] }}</p>
                                        @if (!empty($item['is_email']))
                                            <a href="mailto:{{ $item['value'] }}" class="mt-0.5 text-sm font-medium text-blue-500 hover:underline">{{ $item['value'] }}</a>
                                        @else
                                            <p class="mt-0.5 text-sm font-medium" style="color: var(--portal-text)">{{ $item['value'] }}</p>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
