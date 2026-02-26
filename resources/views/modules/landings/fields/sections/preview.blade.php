<x-form-section>
    <x-slot:labelText>{{ __('Live Preview') }}</x-slot:labelText>
    <x-landing.live-preview :preview-data="$previewData ?? []" />
</x-form-section>
