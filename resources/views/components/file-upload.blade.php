@props([
    'name' => 'file',
    'id' => null,
    'accept' => null,
    'required' => false,
    'buttonLabel' => __('ui.choose_file'),
    'placeholder' => __('ui.no_file_selected'),
])

@php
    $normalizedName = is_string($name) ? str_replace(['[', ']', '.'], '-', $name) : 'file';
    $inputId = $id ?? sprintf('%s-%s', trim($normalizedName, '-'), strtolower(\Illuminate\Support\Str::random(6)));
@endphp

<div {{ $attributes->merge(['class' => 'flex min-w-0 items-center gap-2']) }} x-data="{ emptyLabel: @js($placeholder), fileName: @js($placeholder) }">
    <input x-ref="fileInput" id="{{ $inputId }}" name="{{ $name }}" type="file" class="sr-only"
        @if ($accept) accept="{{ $accept }}" @endif
        @if ($required) required @endif
        @change="fileName = $event.target.files.length ? $event.target.files[0].name : emptyLabel">

    <x-button type="button" variant="outline" @click="$refs.fileInput.click()">
        {{ $buttonLabel }}
    </x-button>

    <span
        class="flex h-9 min-w-0 flex-1 items-center truncate rounded-md border border-input bg-background px-3 py-1 text-sm"
        :class="fileName === emptyLabel ? 'text-muted-foreground' : 'text-foreground'" x-text="fileName">
    </span>
</div>
