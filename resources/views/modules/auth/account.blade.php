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
            : __('Last 6 months');
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
                ? __('Trending up from :previous to :current this month', [
                    'previous' => $previousLoginCount,
                    'current' => $latestLoginCount,
                ])
                : ($previousLoginCount > 0
                    ? ($latestLoginCount >= $previousLoginCount
                        ? __('Trending up by :percent% this month', ['percent' => $monthlyTrendPercent])
                        : __('Trending down by :percent% this month', ['percent' => $monthlyTrendPercent]))
                    : __('No logins this month'));
    @endphp

    <div class="space-y-6">
        <div class="grid grid-cols-1 gap-6 xl:grid-cols-2">
            <x-card module class="h-full">
                <x-card-header flush>
                    <x-card-title>{{ __('Profile Information') }}</x-card-title>
                    <x-card-description>{{ __("Update your account's profile information and email address.") }}</x-card-description>
                </x-card-header>

                <x-card-content flush class="space-y-4">
                    @if (session('status') === 'profile-updated')
                        <x-alert>
                            <x-alert-description>{{ __('Saved.') }}</x-alert-description>
                        </x-alert>
                    @endif

                    {{ html()->form('PATCH', route('account.update'))->class('space-y-4')->open() }}
                    <div class="space-y-1.5">
                        <x-label for="account_name">{{ __('Name') }}</x-label>
                        <x-input id="account_name" type="text" name="name" class="w-full" :value="old('name', Auth::user()->name)" />
                        @error('name')
                            <p class="text-sm text-destructive">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-1.5">
                        <x-label for="account_email">{{ __('Email') }}</x-label>
                        <x-input id="account_email" type="email" name="email" class="w-full" :value="old('email', Auth::user()->email)" />
                        @error('email')
                            <p class="text-sm text-destructive">{{ $message }}</p>
                        @enderror
                    </div>

                    <x-button type="submit">{{ __('Save Changes') }}</x-button>
                    {{ html()->form()->close() }}
                </x-card-content>
            </x-card>

            <div class="min-w-0 h-full min-h-[360px] md:min-h-[420px]" data-react-radar-dots-chart
                data-chart-data="{{ json_encode($monthlyLoginActivityChartData) }}"
                data-title="{{ __('Login Activity by Month') }}" data-series-label="{{ __('Logins') }}"
                data-description="{{ __('Showing your successful logins for the last 6 months') }}"
                data-footer-trend="{{ $chartTrendLabel }}" data-footer-description="{{ $chartPeriod }}"></div>
        </div>

        <x-card module>
            <x-card-header flush>
                <x-card-title>{{ __('Update Password') }}</x-card-title>
                <x-card-description>{{ __('Ensure your account is using a long, random password to stay secure.') }}</x-card-description>
            </x-card-header>

            <x-card-content flush class="space-y-4">
                @if (session('status') === 'password-updated')
                    <x-alert>
                        <x-alert-description>{{ __('Saved.') }}</x-alert-description>
                    </x-alert>
                @endif

                {{ html()->form('PUT', route('password.update'))->class('space-y-4')->open() }}
                <div class="space-y-1.5">
                    <x-label for="account_current_password">{{ __('Current Password') }}</x-label>
                    <x-input id="account_current_password" type="password" name="current_password" class="w-full"
                        autocomplete="current-password" />
                    @if ($errors->updatePassword->has('current_password'))
                        <p class="text-sm text-destructive">{{ $errors->updatePassword->first('current_password') }}
                        </p>
                    @endif
                </div>

                <div class="space-y-1.5">
                    <x-label for="account_password">{{ __('New Password') }}</x-label>
                    <x-input id="account_password" type="password" name="password" class="w-full"
                        autocomplete="new-password" />
                    @if ($errors->updatePassword->has('password'))
                        <p class="text-sm text-destructive">{{ $errors->updatePassword->first('password') }}</p>
                    @endif
                </div>

                <div class="space-y-1.5">
                    <x-label for="account_password_confirmation">{{ __('Confirm Password') }}</x-label>
                    <x-input id="account_password_confirmation" type="password" name="password_confirmation"
                        class="w-full" autocomplete="new-password" />
                    @if ($errors->updatePassword->has('password_confirmation'))
                        <p class="text-sm text-destructive">
                            {{ $errors->updatePassword->first('password_confirmation') }}</p>
                    @endif
                </div>

                <x-button type="submit">{{ __('Save Password') }}</x-button>
                {{ html()->form()->close() }}
            </x-card-content>
        </x-card>

        <x-card module>
            <x-card-header flush>
                <x-card-title>{{ __('Delete Account') }}</x-card-title>
                <x-card-description>{{ __('Once your account is deleted, all of its resources and data will be permanently deleted.') }}</x-card-description>
            </x-card-header>

            <x-card-content flush class="space-y-4">
                {{ html()->form('DELETE', route('account.destroy'))->class('space-y-4')->open() }}
                <div class="space-y-1.5">
                    <x-label for="account_delete_password">{{ __('Password') }}</x-label>
                    <x-input id="account_delete_password" type="password" name="password" class="w-full"
                        autocomplete="current-password" />
                    @if ($errors->accountDeletion->has('password'))
                        <p class="text-sm text-destructive">{{ $errors->accountDeletion->first('password') }}</p>
                    @endif
                </div>

                <x-button type="submit" variant="destructive">{{ __('Delete Account') }}</x-button>
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
