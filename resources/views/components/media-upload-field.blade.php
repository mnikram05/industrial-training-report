@props([
    'id',
    'name',
    'label',
    'path' => null,
    'errorKey',
    'uploadClass' => 'w-full flex-col items-stretch md:flex-row md:items-center',
])

<div class="min-w-0 space-y-1.5">
    <x-label :for="$id">{{ $label }}</x-label>

    <x-file-upload :id="$id" :name="$name" accept="image/*" :class="$uploadClass"
        button-label="{{ __('Upload Image') }}" placeholder="{{ __('No image selected') }}" />

    @if (filled($path))
        <p class="break-all text-xs text-muted-foreground">
            {{ __('Current image: :path', ['path' => $path]) }}
        </p>
    @endif

    @error($errorKey)
        <p class="text-sm text-destructive">{{ $message }}</p>
    @enderror
</div>
