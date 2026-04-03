<x-app-layout>

    <div class="grid grid-cols-1 gap-3 sm:gap-4 md:grid-cols-2 xl:grid-cols-4">
        <x-card class="gap-3 p-4 py-4 sm:gap-6 sm:p-6 sm:py-6">
            <x-card-header flush class="gap-1">
                <x-card-title class="text-sm sm:text-base">{{ __('ui.total_users') }}</x-card-title>
            </x-card-header>
            <x-card-content flush>
                <p class="text-2xl font-semibold sm:text-3xl">{{ number_format($totalUsers) }}</p>
            </x-card-content>
        </x-card>

        <x-card class="gap-3 p-4 py-4 sm:gap-6 sm:p-6 sm:py-6">
            <x-card-header flush class="gap-1">
                <x-card-title class="text-sm sm:text-base">{{ __('ui.total_articles') }}</x-card-title>
            </x-card-header>
            <x-card-content flush>
                <p class="text-2xl font-semibold sm:text-3xl">{{ number_format($totalArticles) }}</p>
            </x-card-content>
        </x-card>

        <x-card class="gap-3 p-4 py-4 sm:gap-6 sm:p-6 sm:py-6">
            <x-card-header flush class="gap-1">
                <x-card-title class="text-sm sm:text-base">{{ __('ui.published_articles') }}</x-card-title>
            </x-card-header>
            <x-card-content flush>
                <p class="text-2xl font-semibold sm:text-3xl">{{ number_format($publishedArticles) }}</p>
            </x-card-content>
        </x-card>

        <x-card class="gap-3 p-4 py-4 sm:gap-6 sm:p-6 sm:py-6">
            <x-card-header flush class="gap-1">
                <x-card-title class="text-sm sm:text-base">{{ __('ui.roles') }}</x-card-title>
            </x-card-header>
            <x-card-content flush>
                <p class="text-2xl font-semibold sm:text-3xl">{{ number_format($totalRoles) }}</p>
            </x-card-content>
        </x-card>

        <div class="md:col-span-2 xl:col-span-4">
            <div class="grid grid-cols-1 gap-4 xl:grid-cols-4">
                <div class="xl:col-span-2">
                    <x-admin-dashboard.auth-activity-chart :data="$authenticationActivityData" />
                </div>

                <div class="xl:col-span-1">
                    <x-admin-dashboard.user-role-radial-chart :data="$userRoleDistributionData" />
                </div>

                <div class="xl:col-span-1">
                    <x-admin-dashboard.user-role-radial-grid-chart :data="$activityByCategoryData" />
                </div>
            </div>
        </div>

        <div class="md:col-span-2 xl:col-span-4">
            <x-admin-dashboard.latest-activity-items :items="$latestActivityItems" />
        </div>
    </div>
</x-app-layout>
