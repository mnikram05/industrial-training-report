<x-app-layout>
    <x-module-index-shell>
        <x-slot:heading>
            @if ($selectedPage)
                {{ $pages->flatMap(fn ($group) => $group)->get($selectedPage, __('modules/portal-administration/portal-setting.plural')) }}
            @else
                {{ __('modules/portal-administration/portal-setting.plural') }}
            @endif
        </x-slot:heading>
        <x-slot:subtitle>{{ __('modules/portal-administration/portal-setting.subtitle') }}</x-slot:subtitle>

        <x-card module>
            <x-card-content flush>
                @if (session('status') === 'settings-updated')
                    <div class="mb-4 rounded-md bg-green-50 p-3 text-sm text-green-700">
                        {{ __('modules/portal-administration/portal-setting.messages.updated') }}
                    </div>
                @endif

                @if ($selectedPage)
                    {{ html()->form('PUT', route('portal-settings.update'))->id('portal-settings-form')->open() }}
                    <input type="hidden" name="page" value="{{ $selectedPage }}" />

                    <div class="space-y-6 pb-6">
                        @if ($selectedPage === 'header-footer')
                            @include('portaladministration::portal.partials.settings-header-footer')
                        @elseif ($selectedPage === 'cms')
                            @include('portaladministration::portal.partials.settings-cms')
                        @else
                            @include('portaladministration::portal.partials.settings-blocks')
                        @endif
                    </div>

                    {{ html()->form()->close() }}

                    <x-button-group plain end>
                        <x-button as="a" variant="outline" href="{{ route('portal-administration.menus.index') }}">{{ __('crud.cancel') }}</x-button>
                        <x-button type="submit" form="portal-settings-form">{{ __('modules/portal-administration/portal-setting.save') }}</x-button>
                    </x-button-group>
                @else
                    <p class="py-8 text-center text-muted-foreground">{{ __('modules/portal-administration/portal-setting.messages.no_page') }}</p>
                @endif
            </x-card-content>
        </x-card>
    </x-module-index-shell>
</x-app-layout>
