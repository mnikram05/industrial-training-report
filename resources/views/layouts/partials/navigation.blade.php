<nav x-data="{ open: false, profileOpen: false, langOpen: false }" x-init="$store.layout.boot()" class="contents">
    <div
        class="fixed inset-x-0 top-0 z-30 border-b border-white/10 bg-[var(--portal-header-bg)] backdrop-blur supports-[backdrop-filter]:bg-[color-mix(in_srgb,var(--portal-header-bg)_92%,transparent)] lg:hidden">
        <div class="flex h-14 items-center justify-between px-4">
            <a href="{{ route('dashboard') }}"
                class="inline-flex items-center gap-2 text-sm font-semibold text-white/95">
                <svg class="size-5 text-[var(--portal-accent)]" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3l8 4.5v9L12 21l-8-4.5v-9L12 3z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 12l8-4.5M12 12L4 7.5M12 12v9" />
                </svg>
                <span>{{ config('app.name') }}</span>
            </a>

            <button type="button" @click="open = !open"
                class="inline-flex items-center justify-center rounded-md border border-white/15 bg-white/5 p-2 text-white/80 shadow-none transition hover:bg-[color-mix(in_srgb,var(--portal-accent)_28%,transparent)] hover:text-white">
                <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round"
                        stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                        stroke-linejoin="round" d="M6 6l12 12M18 6L6 18" />
                </svg>
            </button>
        </div>
    </div>

    <div x-cloak x-show="open" x-transition.opacity @click="open = false"
        class="fixed inset-0 z-40 bg-black/40 lg:hidden"></div>

    <aside
        :class="[open ? 'translate-x-0' : '-translate-x-full', $store.layout.sidebarCollapsed ? 'lg:-translate-x-full' :
            'lg:translate-x-0'
        ]"
        class="js-sidebar fixed inset-y-0 left-0 z-50 flex w-60 -translate-x-full transform flex-col border-r border-white/10 bg-[var(--portal-header-bg)] shadow-[inset_-3px_0_0_var(--portal-accent)] transition duration-300 ease-out lg:translate-x-0">
        <x-sidebar-header class="!border-b-0 border-white/10 bg-transparent px-2.5 py-2.5">
            <div class="relative" @click.outside="langOpen = false">
                <button type="button" @click="langOpen = !langOpen"
                    :class="$store.layout.sidebarCollapsed ? 'justify-center px-0' : ''"
                    class="inline-flex h-11 w-full items-center gap-2.5 rounded-lg border border-white/15 bg-white/5 px-2.5 text-left shadow-none transition-colors hover:bg-[color-mix(in_srgb,var(--portal-accent)_22%,transparent)]">
                    <span
                        class="flex size-7 items-center justify-center rounded-md bg-[var(--portal-accent)] text-white shadow-sm">
                        <svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 3l8 4.5v9L12 21l-8-4.5v-9L12 3z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 12l8-4.5M12 12L4 7.5M12 12v9" />
                        </svg>
                    </span>
                    <span class="min-w-0 flex-1" x-show="!$store.layout.sidebarCollapsed">
                        <span
                            class="block truncate text-sm font-semibold text-white">{{ config('app.name') }}</span>
                        <span class="block truncate text-[11px] text-white/50">{{ $localeLabel }}</span>
                    </span>
                    <svg x-show="!$store.layout.sidebarCollapsed"
                        class="size-4 text-white/45 transition-transform duration-200"
                        :class="{ 'rotate-180': langOpen }" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m7 10 5-5 5 5" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="m7 14 5 5 5-5" />
                    </svg>
                </button>

                <div x-cloak x-show="langOpen" x-transition.opacity.duration.150ms
                    :class="$store.layout.sidebarCollapsed ? 'left-0 w-44' : 'inset-x-0'"
                    class="absolute top-[calc(100%+0.375rem)] z-30 rounded-md border border-border bg-popover p-1 shadow-md">
                    <p class="px-2 py-1 text-[11px] font-medium text-muted-foreground">{{ __('Language') }}</p>

                    <div class="mt-1 space-y-1">
                        <form method="POST" action="{{ route('locale.switch') }}">
                            @csrf
                            <input type="hidden" name="locale" value="en">
                            <button type="submit"
                                class="{{ $currentLocale === 'en' ? 'bg-accent text-popover-foreground' : 'text-popover-foreground hover:bg-accent/60' }} relative flex w-full items-center justify-between rounded-sm px-2 py-2 text-sm outline-none transition-colors">
                                <span>{{ __('English') }}</span>
                                @if ($currentLocale === 'en')
                                    <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m5 13 4 4L19 7" />
                                    </svg>
                                @endif
                            </button>
                        </form>

                        <form method="POST" action="{{ route('locale.switch') }}">
                            @csrf
                            <input type="hidden" name="locale" value="ms">
                            <button type="submit"
                                class="{{ $currentLocale === 'ms' ? 'bg-accent text-popover-foreground' : 'text-popover-foreground hover:bg-accent/60' }} relative flex w-full items-center justify-between rounded-sm px-2 py-2 text-sm outline-none transition-colors">
                                <span>{{ __('Melayu') }}</span>
                                @if ($currentLocale === 'ms')
                                    <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m5 13 4 4L19 7" />
                                    </svg>
                                @endif
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </x-sidebar-header>

        <x-sidebar-content class="bg-transparent px-1.5 py-1.5">
            @include('layouts.partials.menu')
        </x-sidebar-content>

        <x-sidebar-footer class="!border-t-0 border-white/10 bg-transparent p-2">
            <div class="relative" @click.outside="profileOpen = false">
                <div x-cloak x-show="profileOpen" x-transition.opacity.duration.150ms
                    class="absolute inset-x-0 bottom-full mb-2 z-50 rounded-md border border-border bg-popover p-1 shadow-md">
                    <div class="mb-1 flex items-center gap-3 rounded-sm px-2 py-2">
                        <x-avatar>
                            <x-avatar-fallback>{{ $avatarFallback }}</x-avatar-fallback>
                            <x-avatar-badge :impersonating="$isImpersonating" />
                        </x-avatar>
                        <div class="min-w-0">
                            <p class="truncate text-sm font-medium text-popover-foreground">{{ $user->name }}</p>
                            <p class="truncate text-xs text-muted-foreground">{{ $user->email }}</p>
                        </div>
                    </div>

                    <x-separator class="my-1" />

                    <a href="{{ $profileEditUrl }}"
                        class="focus:bg-accent focus:text-accent-foreground hover:bg-accent hover:text-accent-foreground relative flex w-full select-none items-center gap-2 rounded-sm px-2 py-1.5 text-sm outline-none">
                        {{ __('Account') }}
                    </a>

                    <x-separator class="my-1" />

                    {{ html()->form('POST', route('logout'))->class('w-full')->open() }}
                    <button type="submit"
                        class="focus:bg-accent focus:text-accent-foreground hover:bg-accent hover:text-accent-foreground relative flex w-full select-none items-center justify-start rounded-sm px-2 py-1.5 text-left text-sm font-medium text-popover-foreground outline-none">
                        {{ __('Log Out') }}
                    </button>
                    {{ html()->form()->close() }}

                    @if ($isImpersonating)
                        <x-separator class="my-1" />
                        <a href="{{ route('impersonate.leave') }}"
                            class="focus:bg-accent hover:bg-accent relative flex w-full select-none items-center justify-start rounded-sm px-2 py-1.5 text-left text-sm font-medium text-orange-600 outline-none transition-colors hover:text-orange-600 dark:text-orange-400 dark:hover:text-orange-400">
                            {{ __('Stop Impersonating') }}
                        </a>
                    @endif
                </div>

                <button type="button" @click="profileOpen = !profileOpen"
                    :class="$store.layout.sidebarCollapsed ? 'justify-center px-0' : ''"
                    class="inline-flex w-full items-center gap-3 rounded-md px-2 py-2 text-left text-white transition-colors hover:bg-[color-mix(in_srgb,var(--portal-accent)_18%,transparent)]">
                    <x-avatar>
                        <x-avatar-fallback>{{ $avatarFallback }}</x-avatar-fallback>
                        <x-avatar-badge :impersonating="$isImpersonating" />
                    </x-avatar>
                    <div class="min-w-0 flex-1" x-show="!$store.layout.sidebarCollapsed">
                        <p class="truncate text-sm font-medium text-white">{{ $user->name }}</p>
                        <p class="truncate text-xs text-white/50">{{ $user->email }}</p>
                    </div>
                    <svg x-show="!$store.layout.sidebarCollapsed"
                        class="size-4 text-white/45 transition-transform duration-200"
                        :class="{ 'rotate-180': profileOpen }" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m7 10 5-5 5 5" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="m7 14 5 5 5-5" />
                    </svg>
                </button>
            </div>
        </x-sidebar-footer>
    </aside>
</nav>
