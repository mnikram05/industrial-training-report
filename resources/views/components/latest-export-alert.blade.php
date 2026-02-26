@props([
    'path' => null,
])

@if (is_string($path) && $path !== '')
    <x-alert inline x-data="{ open: true }" x-show="open" x-cloak x-transition.opacity.duration-150>
        <x-alert-description class="m-0">{{ __('Latest export is ready to download.') }}</x-alert-description>
        <x-button as="a" href="{{ route('exports.download', ['path' => $path]) }}" size="sm"
            variant="secondary" class="shrink-0" @click="open = false">
            {{ __('Download') }}
        </x-button>
    </x-alert>
@endif
