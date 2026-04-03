@props([
    'resource' => null,
    'createLabel' => null,
    'showExport' => true,
    'showImport' => true,
    'showCreate' => true,
    'importButtonLabel' => __('ui.import_xlsx'),
    'importInputName' => 'file',
])

@php
    $hasResource = is_string($resource) && $resource !== '';
    $resolvedCreateLabel = isset($create) && $create->hasActualContent() ? trim((string) $create) : $createLabel;
    $hasExportAction = $showExport === true && $hasResource;
    $hasImportAction = $showImport === true && $hasResource;
    $hasCreateAction =
        $showCreate === true && $hasResource && is_string($resolvedCreateLabel) && $resolvedCreateLabel !== '';
@endphp

@if ($hasExportAction)
    <a href="{{ route($resource . '.export') }}">
        <x-button variant="outline">{{ __('ui.export') }}</x-button>
    </a>
@endif

@if ($hasImportAction)
    {{ html()->form('POST', route($resource . '.import'))->attribute('enctype', 'multipart/form-data')->class('flex w-full flex-col gap-2 sm:flex-row sm:items-center lg:w-auto')->open() }}
    <x-file-upload name="{{ $importInputName }}"
        class="w-full sm:flex-1 lg:w-auto lg:min-w-[20rem] lg:max-w-[24rem] xl:min-w-[22rem] xl:max-w-[26rem] lg:shrink-0"
        required />
    <x-button type="submit" variant="secondary">{{ $importButtonLabel }}</x-button>
    {{ html()->form()->close() }}
@endif

@if ($hasCreateAction)
    <a href="{{ route($resource . '.create') }}">
        <x-button>{{ $resolvedCreateLabel }}</x-button>
    </a>
@endif
