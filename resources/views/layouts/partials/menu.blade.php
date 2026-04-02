<div class="space-y-3 pb-1" x-data="{ cmsOpen: @js($cmsOpen), referencesOpen: @js($referencesOpen), portalOpen: @js($portalOpen) }">
    <x-sidebar-group>
        <x-sidebar-group-label>{{ __('sidebar.platform') }}</x-sidebar-group-label>

        <x-sidebar-menu-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" :title="__('sidebar.dashboard')">
            <span class="inline-flex size-4 shrink-0 items-center justify-center" aria-hidden="true">
                <svg class="size-4 text-white/45 group-hover:text-white/90" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <rect x="3" y="3" width="7" height="7" rx="1" />
                    <rect x="14" y="3" width="7" height="4" rx="1" />
                    <rect x="14" y="11" width="7" height="10" rx="1" />
                    <rect x="3" y="14" width="7" height="7" rx="1" />
                </svg>
            </span>
            <span class="min-w-0 flex-1 truncate">{{ __('sidebar.dashboard') }}</span>
            <span class="size-4 shrink-0" aria-hidden="true"></span>
        </x-sidebar-menu-link>

        <button type="button" @click="cmsOpen = !cmsOpen"
            class="group flex h-8 w-full min-w-0 items-center gap-2 rounded-md px-2 text-left text-[13px] font-medium text-white/85 transition-colors hover:bg-[color-mix(in_srgb,var(--portal-accent)_22%,transparent)] hover:text-white">
            <span class="inline-flex size-4 shrink-0 items-center justify-center" aria-hidden="true">
                <svg class="size-4 text-white/45 group-hover:text-white/85" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3 7a2 2 0 0 1 2-2h5l2 2h7a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V7z" />
                </svg>
            </span>
            <span class="min-w-0 flex-1 truncate text-left">{{ __('sidebar.cms') }}</span>
            <svg
                class="size-4 text-white/45 transition-transform duration-200 group-hover:text-white/80" :class="{ 'rotate-90': cmsOpen }"
                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="m9 6 6 6-6 6" />
            </svg>
        </button>

        <div x-cloak x-show="cmsOpen" x-transition.opacity.duration.150ms>
            <x-sidebar-submenu>
                @can(\App\Modules\Role\Constants\RolePermissionConstants::ADMIN_DASHBOARD_VIEW)
                    <x-sidebar-submenu-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                        <span>{{ __('sidebar.admin_dashboard') }}</span>
                    </x-sidebar-submenu-link>
                @endcan

                @can(\App\Modules\Role\Constants\RolePermissionConstants::LANDINGS_VIEW)
                    <x-sidebar-submenu-link :href="route('landings.index')" :active="request()->routeIs('landings.*')">
                        <span>{{ __('sidebar.landings') }}</span>
                    </x-sidebar-submenu-link>
                @endcan

                @can(\App\Modules\Role\Constants\RolePermissionConstants::STATUSES_VIEW)
                    <x-sidebar-submenu-link :href="route('statuses.index')" :active="request()->routeIs('statuses.*')">
                        <span>{{ __('sidebar.statuses') }}</span>
                    </x-sidebar-submenu-link>
                @endcan

                @can(\App\Modules\Role\Constants\RolePermissionConstants::USERS_VIEW)
                    <x-sidebar-submenu-link :href="route('users.index')" :active="request()->routeIs('users.*')">
                        <span>{{ __('sidebar.users') }}</span>
                    </x-sidebar-submenu-link>
                @endcan

                @can(\App\Modules\Role\Constants\RolePermissionConstants::ROLES_VIEW)
                    <x-sidebar-submenu-link :href="route('roles.index')" :active="request()->routeIs('roles.*')">
                        <span>{{ __('sidebar.roles') }}</span>
                    </x-sidebar-submenu-link>
                @endcan

                @can(\App\Modules\Role\Constants\RolePermissionConstants::ACTIVITY_LOGS_VIEW)
                    <x-sidebar-submenu-link :href="route('activity-logs.index')" :active="request()->routeIs('activity-logs.*')">
                        <span>{{ __('sidebar.activity_logs') }}</span>
                    </x-sidebar-submenu-link>
                @endcan

            </x-sidebar-submenu>
        </div>

        <x-sidebar-menu-link :href="route('portal.home')" :active="request()->routeIs('portal.*')" :title="__('sidebar.portal')">
            <span class="inline-flex size-4 shrink-0 items-center justify-center" aria-hidden="true">
                <svg class="size-4 text-white/45 group-hover:text-white/90" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5M13.5 6L21 3m0 0v5.25M21 3h-5.25" />
                </svg>
            </span>
            <span class="min-w-0 flex-1 truncate">{{ __('sidebar.portal') }}</span>
            <span class="size-4 shrink-0" aria-hidden="true"></span>
        </x-sidebar-menu-link>

        <button type="button" @click="portalOpen = !portalOpen"
            class="group flex h-8 w-full min-w-0 items-center gap-2 rounded-md px-2 text-left text-[13px] font-medium text-white/85 transition-colors hover:bg-[color-mix(in_srgb,var(--portal-accent)_22%,transparent)] hover:text-white">
            <span class="inline-flex size-4 shrink-0 items-center justify-center" aria-hidden="true">
                <svg class="size-4 text-white/45 group-hover:text-white/85" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 21a9.004 9.004 0 0 0 8.716-6.747M12 21a9.004 9.004 0 0 1-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 0 1 7.843 4.582M12 3a8.997 8.997 0 0 0-7.843 4.582m15.686 0A11.953 11.953 0 0 1 12 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0 1 21 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0 1 12 16.5a17.92 17.92 0 0 1-8.716-2.247m0 0A8.966 8.966 0 0 1 3 12c0-1.264.26-2.467.732-3.558" />
                </svg>
            </span>
            <span class="min-w-0 flex-1 truncate text-left">{{ __('sidebar.portal_administration') }}</span>
            <svg
                class="size-4 text-white/45 transition-transform duration-200 group-hover:text-white/80" :class="{ 'rotate-90': portalOpen }"
                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="m9 6 6 6-6 6" />
            </svg>
        </button>

        <div x-cloak x-show="portalOpen" x-transition.opacity.duration.150ms>
            <x-sidebar-submenu>
                <x-sidebar-submenu-link :href="route('portal-administration.menus.index')" :active="request()->routeIs('portal-administration.menus.*')">
                    <span>{{ __('sidebar.menus') }}</span>
                </x-sidebar-submenu-link>

                @can(\App\Modules\Role\Constants\RolePermissionConstants::ARTICLES_VIEW)
                    <x-sidebar-submenu-link :href="route('articles.index')" :active="request()->routeIs('articles.*')">
                        <span>{{ __('sidebar.articles') }}</span>
                    </x-sidebar-submenu-link>
                @endcan

                <x-sidebar-submenu-link :href="route('media.index')" :active="request()->routeIs('media.*')">
                    <span>{{ __('sidebar.media') }}</span>
                </x-sidebar-submenu-link>

            </x-sidebar-submenu>
        </div>

        <button type="button" @click="referencesOpen = !referencesOpen"
            class="group flex h-8 w-full min-w-0 items-center gap-2 rounded-md px-2 text-left text-[13px] font-medium text-white/85 transition-colors hover:bg-[color-mix(in_srgb,var(--portal-accent)_22%,transparent)] hover:text-white">
            <span class="inline-flex size-4 shrink-0 items-center justify-center" aria-hidden="true">
                <svg class="size-4 text-white/45 group-hover:text-white/85" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                </svg>
            </span>
            <span class="min-w-0 flex-1 truncate text-left">{{ __('sidebar.references') }}</span>
            <svg
                class="size-4 text-white/45 transition-transform duration-200 group-hover:text-white/80" :class="{ 'rotate-90': referencesOpen }"
                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="m9 6 6 6-6 6" />
            </svg>
        </button>

        <div x-cloak x-show="referencesOpen" x-transition.opacity.duration.150ms>
            <x-sidebar-submenu>
                @can(\App\Modules\Role\Constants\RolePermissionConstants::STATES_VIEW)
                    <x-sidebar-submenu-link :href="route('reference.states.index')" :active="request()->routeIs('reference.states.*')">
                        <span>{{ __('sidebar.states') }}</span>
                    </x-sidebar-submenu-link>
                @endcan

                @can(\App\Modules\Role\Constants\RolePermissionConstants::PARLIAMENTS_VIEW)
                    <x-sidebar-submenu-link :href="route('reference.parliaments.index')" :active="request()->routeIs('reference.parliaments.*')">
                        <span>{{ __('sidebar.parliaments') }}</span>
                    </x-sidebar-submenu-link>
                @endcan

                <x-sidebar-submenu-link :href="route('reference.data-references.index')" :active="request()->routeIs('reference.data-references.*')">
                    <span>{{ __('sidebar.data_references') }}</span>
                </x-sidebar-submenu-link>
            </x-sidebar-submenu>
        </div>

        <x-sidebar-menu-link
            :href="route('portal-settings.edit', ['page' => 'cms'])"
            :active="request()->routeIs('portal-settings.edit') && request('page') === 'cms'"
            :title="__('sidebar.cms_settings')">
            <span class="inline-flex size-4 shrink-0 items-center justify-center" aria-hidden="true">
                <svg class="size-4 text-white/45 group-hover:text-white/90" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.932 6.932 0 0 1 0 .255c-.007.38.138.754.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.431l1.004-.827c.292-.24.437-.613.43-.991a6.932 6.932 0 0 1 0-.255c.007-.38-.138-.754-.43-.99l-1.004-.828a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.213-1.28Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                </svg>
            </span>
            <span class="min-w-0 flex-1 truncate">{{ __('sidebar.cms_settings') }}</span>
            <span class="size-4 shrink-0" aria-hidden="true"></span>
        </x-sidebar-menu-link>
    </x-sidebar-group>
</div>
