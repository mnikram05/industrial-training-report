<nav x-data="{
    profileOpen: false,
    headerProfileOpen: false,
    toggleFullscreen() {
        if (!document.fullscreenElement) {
            document.documentElement.requestFullscreen?.();
        } else {
            document.exitFullscreen?.();
        }
    },
}" x-init="$store.layout.boot()" class="block min-h-0">
    {{-- Satu bar penuh lebar: [logo Poli | bar alat] — elak logo nampak “bawah” bar putih (z-index / left-60) --}}
    <header
        class="fixed left-0 right-0 top-0 z-[60] flex h-14 items-stretch border-b border-slate-200/80 shadow-sm lg:h-20 dark:border-slate-800">
        {{-- Kiri: logo Poli (lg+); !hidden bila sidebar dilipat — bar lg lebih tinggi supaya logo boleh jelas lebih besar --}}
        <div
            class="hidden h-full min-h-0 w-36 shrink-0 items-center justify-center border-r border-slate-300/35 bg-[var(--portal-header-bg)] px-2 sm:w-48 md:w-52 lg:flex lg:w-60 lg:px-1 dark:border-white/20">
            <a href="{{ route('dashboard') }}"
                class="flex h-full min-h-0 w-full min-w-0 max-w-full items-center justify-center px-2 py-1.5 transition-colors hover:bg-black/[0.08] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[var(--portal-accent)] focus-visible:ring-inset lg:px-0.5 lg:py-0.5"
                title="{{ $cmsHeaderBrandLine }}">
                @if (!empty($cmsPortalLogoUrl))
                    <img src="{{ $cmsPortalLogoUrl }}" alt="{{ $cmsHeaderBrandLine }}"
                        class="mx-auto block h-auto min-h-0 w-auto min-w-0 max-h-10 max-w-[8.25rem] object-contain object-center drop-shadow-sm sm:max-h-11 sm:max-w-[9.5rem] lg:max-h-[4.75rem] lg:w-full lg:max-w-[min(100%,14.875rem)]" />
                @else
                    <span
                        class="line-clamp-2 px-1 text-center text-[9px] font-bold uppercase leading-tight tracking-wide text-white sm:text-[10px]">{{ $cmsHeaderBrandLine }}</span>
                @endif
            </a>
        </div>
        {{-- Kanan: masa, portal, bahasa, dll. --}}
        <div
            class="flex min-h-0 min-w-0 flex-1 items-center justify-between gap-2 overflow-visible bg-gradient-to-r from-slate-100 via-white to-slate-100/95 px-2 sm:gap-3 sm:px-3 lg:px-5 dark:from-slate-950 dark:via-slate-900 dark:to-slate-950">
            <div class="flex min-w-0 flex-1 items-center gap-2 sm:gap-2.5">
                <div class="hidden items-center gap-2 sm:flex" x-data="adminHeaderClock">
                    <div
                        class="inline-flex items-center gap-1.5 rounded-full border border-slate-200/80 bg-white px-3 py-1.5 text-xs font-semibold tabular-nums text-slate-700 shadow-md dark:border-slate-600 dark:bg-slate-800 dark:text-slate-100">
                        <svg class="size-3.5 shrink-0 text-slate-500 dark:text-slate-400" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <circle cx="12" cy="12" r="9" />
                            <path stroke-linecap="round" d="M12 7v5l3 2" />
                        </svg>
                        <span x-text="time"></span>
                    </div>
                    <div
                        class="inline-flex items-center gap-1.5 rounded-full border border-slate-200/80 bg-white px-3 py-1.5 text-xs font-semibold text-slate-700 shadow-md dark:border-slate-600 dark:bg-slate-800 dark:text-slate-100">
                        <svg class="size-3.5 shrink-0 text-slate-500 dark:text-slate-400" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <rect x="3" y="5" width="18" height="16" rx="2" />
                            <path stroke-linecap="round" d="M3 10h18M8 3v4M16 3v4" />
                        </svg>
                        <span class="max-w-[11rem] truncate sm:max-w-none" x-text="dateLine"></span>
                    </div>
                </div>
            </div>

            <div class="flex shrink-0 flex-nowrap items-center gap-1.5 sm:gap-2">
                <a href="{{ route('portal.home') }}" target="_blank" rel="noopener noreferrer"
                    class="inline-flex max-w-[9rem] items-center gap-1.5 truncate rounded-full border border-slate-200/80 bg-white px-2.5 py-1.5 text-xs font-semibold text-[var(--portal-accent)] shadow-md transition hover:bg-slate-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[var(--portal-accent)] sm:max-w-none sm:px-3 dark:border-slate-600 dark:bg-slate-800 dark:hover:bg-slate-700">
                    <span class="truncate">{{ __('sidebar.portal') }}</span>
                    <svg class="size-3.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.8" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5M13.5 6L21 3m0 0v5.25M21 3h-5.25" />
                    </svg>
                </a>

                <div
                    class="inline-flex items-center gap-1.5 rounded-full border border-slate-200/80 bg-white py-0.5 pl-2 pr-0.5 shadow-md dark:border-slate-600 dark:bg-slate-800">
                    <svg class="size-3.5 shrink-0 text-slate-500 dark:text-slate-400" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                        <circle cx="12" cy="12" r="10" />
                        <path stroke-linecap="round"
                            d="M2 12h20M12 2a15 15 0 0 1 0 20 15 15 0 0 1 0-20M12 2v20" />
                    </svg>
                    <div class="flex items-center gap-0.5">
                        <form method="POST" action="{{ route('locale.switch') }}" class="inline">
                            @csrf
                            <button type="submit" name="locale" value="ms"
                                class="rounded-full px-2.5 py-1 text-[11px] font-bold tracking-wide transition sm:text-xs {{ $currentLocale === 'ms' ? 'bg-[var(--portal-accent)] text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-700' }}">
                                BM
                            </button>
                        </form>
                        <form method="POST" action="{{ route('locale.switch') }}" class="inline">
                            @csrf
                            <button type="submit" name="locale" value="en"
                                class="rounded-full px-2.5 py-1 text-[11px] font-bold tracking-wide transition sm:text-xs {{ $currentLocale === 'en' ? 'bg-[var(--portal-accent)] text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-700' }}">
                                EN
                            </button>
                        </form>
                    </div>
                </div>

                <button type="button" @click="toggleFullscreen()"
                    class="inline-flex size-9 shrink-0 items-center justify-center rounded-full border border-slate-200/80 bg-white text-slate-600 shadow-md transition hover:bg-slate-50 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700"
                    title="{{ __('ui.full_screen') }}" aria-label="{{ __('ui.full_screen') }}">
                    <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3" />
                    </svg>
                </button>

                <button type="button" @click="$store.layout.toggleTheme()"
                    class="inline-flex size-9 shrink-0 items-center justify-center rounded-full border border-slate-200/80 bg-white text-slate-600 shadow-md transition hover:bg-slate-50 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700"
                    title="{{ __('ui.theme') }}" aria-label="{{ __('ui.theme') }}">
                    <svg x-cloak x-show="$store.layout.theme !== 'dark'" class="size-4" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 3v2m0 14v2m9-9h-2M5 12H3m15.364 6.364-1.414-1.414M7.05 7.05 5.636 5.636m12.728 0L16.95 7.05M7.05 16.95l-1.414 1.414" />
                        <circle cx="12" cy="12" r="4" />
                    </svg>
                    <svg x-cloak x-show="$store.layout.theme === 'dark'" class="size-4" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21 12.79A9 9 0 1 1 11.21 3A7 7 0 0 0 21 12.79z" />
                    </svg>
                </button>

                <div class="relative z-[70]" @click.outside="headerProfileOpen = false">
                    <button type="button" @click="headerProfileOpen = !headerProfileOpen"
                        class="inline-flex size-9 shrink-0 items-center justify-center rounded-full border-2 border-white bg-white shadow-md ring-1 ring-slate-200/80 dark:border-slate-700 dark:bg-slate-800 dark:ring-slate-600"
                        :aria-expanded="headerProfileOpen" aria-haspopup="true"
                        aria-label="{{ __('ui.account') }}">
                        <x-avatar size="sm">
                            <x-avatar-fallback class="text-[10px]">{{ $avatarFallback }}</x-avatar-fallback>
                        </x-avatar>
                    </button>
                    <div x-cloak x-show="headerProfileOpen" x-transition.opacity.duration.150ms
                        class="absolute right-0 top-full z-[70] mt-2 w-56 rounded-md border border-border bg-popover p-1 shadow-lg">
                        <div class="mb-1 flex items-center gap-3 rounded-sm px-2 py-2">
                            <x-avatar>
                                <x-avatar-fallback>{{ $avatarFallback }}</x-avatar-fallback>
                            </x-avatar>
                            <div class="min-w-0">
                                <p class="truncate text-sm font-medium text-popover-foreground">{{ $user->name }}</p>
                                <p class="truncate text-xs text-muted-foreground">{{ $user->email }}</p>
                            </div>
                        </div>
                        <x-separator class="my-1" />
                        <a href="{{ $profileEditUrl }}"
                            class="focus:bg-accent focus:text-accent-foreground hover:bg-accent hover:text-accent-foreground relative flex w-full select-none items-center gap-2 rounded-sm px-2 py-1.5 text-sm outline-none">
                            {{ __('ui.account') }}
                        </a>
                        <x-separator class="my-1" />
                        {{ html()->form('POST', route('logout'))->class('w-full')->open() }}
                        <button type="submit"
                            class="focus:bg-accent focus:text-accent-foreground hover:bg-accent hover:text-accent-foreground relative flex w-full select-none items-center justify-start rounded-sm px-2 py-1.5 text-left text-sm font-medium text-popover-foreground outline-none">
                            {{ __('ui.log_out') }}
                        </button>
                        {{ html()->form()->close() }}
                        @if ($isImpersonating)
                            <x-separator class="my-1" />
                            <a href="{{ route('impersonate.leave') }}"
                                class="focus:bg-accent hover:bg-accent relative flex w-full select-none items-center justify-start rounded-sm px-2 py-1.5 text-left text-sm font-medium text-orange-600 outline-none transition-colors hover:text-orange-600 dark:text-orange-400 dark:hover:text-orange-400">
                                {{ __('ui.stop_impersonating') }}
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </header>

    <aside id="admin-sidebar-nav"
        class="js-sidebar fixed bottom-0 left-0 top-14 z-[56] flex h-[calc(100dvh-3.5rem)] min-h-0 w-60 max-w-[min(100%,15rem)] translate-x-0 transform flex-col border-r border-slate-300/35 bg-[var(--portal-header-bg)] transition duration-300 ease-out lg:top-20 lg:h-[calc(100dvh-5rem)] lg:max-w-none dark:border-white/20">
        {{-- Logo dalam drawer sahaja (mudah alih); desktop = dalam header atas --}}
        <div class="flex h-24 min-h-0 shrink-0 items-center justify-center border-b border-white/[0.08] bg-[var(--portal-header-bg)] px-1.5 lg:hidden">
            <a href="{{ route('dashboard') }}"
                class="flex h-full min-h-0 w-full min-w-0 items-center justify-center px-0.5 py-0.5 transition-colors hover:bg-black/[0.08] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[var(--portal-accent)] focus-visible:ring-inset"
                title="{{ $cmsHeaderBrandLine }}">
                @if (!empty($cmsPortalLogoUrl))
                    <img src="{{ $cmsPortalLogoUrl }}" alt="{{ $cmsHeaderBrandLine }}"
                        class="mx-auto block h-auto min-h-0 w-full min-w-0 max-h-[5.25rem] max-w-[min(100%,14.875rem)] object-contain object-center drop-shadow-sm" />
                @else
                    <span
                        class="line-clamp-2 px-1 text-center text-[9px] font-bold uppercase leading-tight tracking-wide text-white sm:text-[10px]">{{ $cmsHeaderBrandLine }}</span>
                @endif
            </a>
        </div>

        {{-- Menu: tatal jika panjang --}}
        <x-sidebar-content
            class="min-h-0 flex-1 !gap-0 !bg-transparent !px-3 !pt-8 !pb-4 lg:!pt-12 !shadow-none overscroll-contain">
            @include('layouts.partials.menu')
        </x-sidebar-content>
    </aside>
</nav>
