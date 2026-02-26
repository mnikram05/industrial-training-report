<div class="space-y-4 pb-2" x-data="{ cmsOpen: @js($cmsOpen) }">
    <x-sidebar-group>
        <x-sidebar-group-label x-show="!$store.layout.sidebarCollapsed">{{ __('Platform') }}</x-sidebar-group-label>

        <x-sidebar-menu-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" :title="__('Dashboard')"
            x-bind:class="$store.layout.sidebarCollapsed ? 'justify-center px-0' : ''">
            <svg class="size-4 shrink-0 text-muted-foreground" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2">
                <rect x="3" y="3" width="7" height="7" rx="1" />
                <rect x="14" y="3" width="7" height="4" rx="1" />
                <rect x="14" y="11" width="7" height="10" rx="1" />
                <rect x="3" y="14" width="7" height="7" rx="1" />
            </svg>
            <span x-show="!$store.layout.sidebarCollapsed">{{ __('Dashboard') }}</span>
        </x-sidebar-menu-link>

        <button type="button" @click="cmsOpen = !cmsOpen"
            x-bind:class="$store.layout.sidebarCollapsed ? 'justify-center px-0' : ''"
            class="group flex h-8 w-full items-center gap-2 rounded-md px-2 text-left text-[13px] font-medium text-foreground/90 transition-colors hover:bg-accent hover:text-foreground">
            <svg class="size-4 shrink-0 text-muted-foreground" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M3 7a2 2 0 0 1 2-2h5l2 2h7a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V7z" />
            </svg>
            <span class="flex-1" x-show="!$store.layout.sidebarCollapsed">{{ __('CMS') }}</span>
            <svg x-show="!$store.layout.sidebarCollapsed"
                class="size-4 text-muted-foreground transition-transform duration-200" :class="{ 'rotate-90': cmsOpen }"
                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="m9 6 6 6-6 6" />
            </svg>
        </button>

        <div x-cloak x-show="cmsOpen && !$store.layout.sidebarCollapsed" x-transition.opacity.duration.150ms>
            <x-sidebar-submenu>
                @can(\App\Modules\Role\Constants\RolePermissionConstants::ADMIN_DASHBOARD_VIEW)
                    <x-sidebar-submenu-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                        <span>{{ __('Admin Dashboard') }}</span>
                    </x-sidebar-submenu-link>
                @endcan

                @can(\App\Modules\Role\Constants\RolePermissionConstants::ARTICLES_VIEW)
                    <x-sidebar-submenu-link :href="route('articles.index')" :active="request()->routeIs('articles.*')">
                        <span>{{ __('Articles') }}</span>
                    </x-sidebar-submenu-link>
                @endcan

                @can(\App\Modules\Role\Constants\RolePermissionConstants::LANDINGS_VIEW)
                    <x-sidebar-submenu-link :href="route('landings.index')" :active="request()->routeIs('landings.*')">
                        <span>{{ __('Landings') }}</span>
                    </x-sidebar-submenu-link>
                @endcan

                @can(\App\Modules\Role\Constants\RolePermissionConstants::STATUSES_VIEW)
                    <x-sidebar-submenu-link :href="route('statuses.index')" :active="request()->routeIs('statuses.*')">
                        <span>{{ __('Statuses') }}</span>
                    </x-sidebar-submenu-link>
                @endcan

                @can(\App\Modules\Role\Constants\RolePermissionConstants::USERS_VIEW)
                    <x-sidebar-submenu-link :href="route('users.index')" :active="request()->routeIs('users.*')">
                        <span>{{ __('Users') }}</span>
                    </x-sidebar-submenu-link>
                @endcan

                @can(\App\Modules\Role\Constants\RolePermissionConstants::ROLES_VIEW)
                    <x-sidebar-submenu-link :href="route('roles.index')" :active="request()->routeIs('roles.*')">
                        <span>{{ __('Roles') }}</span>
                    </x-sidebar-submenu-link>
                @endcan

                @can(\App\Modules\Role\Constants\RolePermissionConstants::ACTIVITY_LOGS_VIEW)
                    <x-sidebar-submenu-link :href="route('activity-logs.index')" :active="request()->routeIs('activity-logs.*')">
                        <span>{{ __('Activity Logs') }}</span>
                    </x-sidebar-submenu-link>
                @endcan
            </x-sidebar-submenu>
        </div>
    </x-sidebar-group>
</div>
