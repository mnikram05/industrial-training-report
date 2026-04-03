@props([
    'path' => null,
])

@if (is_string($path) && $path !== '')
    <x-alert inline x-data="{ open: true }" x-show="open" x-cloak x-transition.opacity.duration-150>
        <x-alert-description class="m-0">{{ __('ui.latest_export_is_ready_to_download') }}</x-alert-description>
        <x-button as="a" href="{{ route('exports.download', ['path' => $path]) }}" size="sm"
            variant="secondary" class="shrink-0" @click="open = false">
            {{ __('ui.download') }}
        </x-button>
    </x-alert>
@endif
