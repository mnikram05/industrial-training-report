<x-app-layout>

    @php
        $monthlyLoginActivityChartData = collect($monthlyLoginActivityData ?? [])
            ->map(
                fn(array $item): array => [
                    'month' => (string) data_get($item, 'month', ''),
                    'desktop' => (int) data_get($item, 'desktop', 0),
                ],
            )
            ->values()
            ->all();

        $chartDataCollection = collect($monthlyLoginActivityChartData);
        $monthLabels = $chartDataCollection->pluck('month')->filter()->values();
        $chartPeriod = $monthLabels->isNotEmpty()
            ? $monthLabels->first() . ' - ' . $monthLabels->last()
            : __('ui.last_6_months');
        $latestLoginCount = (int) data_get($chartDataCollection->last(), 'desktop', 0);
        $previousLoginCount = (int) data_get($chartDataCollection->slice(-2, 1)->first(), 'desktop', 0);
        $monthlyTrendPercent =
            $previousLoginCount > 0
                ? number_format(
                    abs((($latestLoginCount - $previousLoginCount) / $previousLoginCount) * 100),
                    1,
                    '.',
                    '',
                )
                : '0.0';
        $chartTrendLabel =
            $latestLoginCount > 0 && $previousLoginCount === 0
                ? __('ui.trending_up_from_previous_to_current_this_month', [
                    'previous' => $previousLoginCount,
                    'current' => $latestLoginCount,
                ])
                : ($previousLoginCount > 0
                    ? ($latestLoginCount >= $previousLoginCount
                        ? __('ui.trending_up_by_percent_this_month', ['percent' => $monthlyTrendPercent])
                        : __('ui.trending_down_by_percent_this_month', ['percent' => $monthlyTrendPercent]))
                    : __('ui.no_logins_this_month'));
    @endphp

    <div class="space-y-6">
        <div class="grid grid-cols-1 gap-6 xl:grid-cols-2">
            <x-card module class="h-full">
                <x-card-header flush>
                    <x-card-title>{{ __('ui.profile_information') }}</x-card-title>
                    <x-card-description>{{ __('ui.update_your_account_s_profile_information_and_email_address') }}</x-card-description>
                </x-card-header>

                <x-card-content flush class="space-y-4">
                    @if (session('status') === 'profile-updated')
                        <x-alert>
                            <x-alert-description>{{ __('ui.saved') }}</x-alert-description>
                        </x-alert>
                    @endif

                    {{ html()->form('PATCH', route('account.update'))->class('space-y-4')->open() }}
                    <div class="space-y-1.5">
                        <x-label for="account_name">{{ __('ui.name') }}</x-label>
                        <x-input id="account_name" type="text" name="name" class="w-full" :value="old('name', Auth::user()->name)" />
                        @error('name')
                            <p class="text-sm text-destructive">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-1.5">
                        <x-label for="account_email">{{ __('ui.email') }}</x-label>
                        <x-input id="account_email" type="email" name="email" class="w-full" :value="old('email', Auth::user()->email)" />
                        @error('email')
                            <p class="text-sm text-destructive">{{ $message }}</p>
                        @enderror
                    </div>

                    <x-button type="submit">{{ __('ui.save_changes') }}</x-button>
                    {{ html()->form()->close() }}
                </x-card-content>
            </x-card>

            <div class="min-w-0 h-full min-h-[360px] md:min-h-[420px]" data-react-radar-dots-chart
                data-chart-data="{{ json_encode($monthlyLoginActivityChartData) }}"
                data-title="{{ __('ui.login_activity_by_month') }}" data-series-label="{{ __('ui.logins') }}"
                data-description="{{ __('ui.showing_your_successful_logins_for_the_last_6_months') }}"
                data-footer-trend="{{ $chartTrendLabel }}" data-footer-description="{{ $chartPeriod }}"></div>
        </div>

        <x-card module>
            <x-card-header flush>
                <x-card-title>{{ __('ui.update_password') }}</x-card-title>
                <x-card-description>{{ __('ui.ensure_your_account_is_using_a_long_random_password_to_stay_secure') }}</x-card-description>
            </x-card-header>

            <x-card-content flush class="space-y-4">
                @if (session('status') === 'password-updated')
                    <x-alert>
                        <x-alert-description>{{ __('ui.saved') }}</x-alert-description>
                    </x-alert>
                @endif

                {{ html()->form('PUT', route('password.update'))->class('space-y-4')->open() }}
                <div class="space-y-1.5">
                    <x-label for="account_current_password">{{ __('ui.current_password') }}</x-label>
                    <x-input id="account_current_password" type="password" name="current_password" class="w-full"
                        autocomplete="current-password" />
                    @if ($errors->updatePassword->has('current_password'))
                        <p class="text-sm text-destructive">{{ $errors->updatePassword->first('current_password') }}
                        </p>
                    @endif
                </div>

                <div class="space-y-1.5">
                    <x-label for="account_password">{{ __('ui.new_password') }}</x-label>
                    <x-input id="account_password" type="password" name="password" class="w-full"
                        autocomplete="new-password" />
                    @if ($errors->updatePassword->has('password'))
                        <p class="text-sm text-destructive">{{ $errors->updatePassword->first('password') }}</p>
                    @endif
                </div>

                <div class="space-y-1.5">
                    <x-label for="account_password_confirmation">{{ __('ui.confirm_password') }}</x-label>
                    <x-input id="account_password_confirmation" type="password" name="password_confirmation"
                        class="w-full" autocomplete="new-password" />
                    @if ($errors->updatePassword->has('password_confirmation'))
                        <p class="text-sm text-destructive">
                            {{ $errors->updatePassword->first('password_confirmation') }}</p>
                    @endif
                </div>

                <x-button type="submit">{{ __('ui.save_password') }}</x-button>
                {{ html()->form()->close() }}
            </x-card-content>
        </x-card>

        <x-card module>
            <x-card-header flush>
                <x-card-title>{{ __('ui.delete_account') }}</x-card-title>
                <x-card-description>{{ __('ui.once_your_account_is_deleted_all_of_its_resources_and_data_will_be_permanently_deleted') }}</x-card-description>
            </x-card-header>

            <x-card-content flush class="space-y-4">
                {{ html()->form('DELETE', route('account.destroy'))->class('space-y-4')->open() }}
                <div class="space-y-1.5">
                    <x-label for="account_delete_password">{{ __('ui.password') }}</x-label>
                    <x-input id="account_delete_password" type="password" name="password" class="w-full"
                        autocomplete="current-password" />
                    @if ($errors->accountDeletion->has('password'))
                        <p class="text-sm text-destructive">{{ $errors->accountDeletion->first('password') }}</p>
                    @endif
                </div>

                <x-button type="submit" variant="destructive">{{ __('ui.delete_account') }}</x-button>
                {{ html()->form()->close() }}
            </x-card-content>
        </x-card>
    </div>

    @once
        @push('scripts')
            @vite('resources/js/charts.jsx')
        @endpush
    @endonce
</x-app-layout>
