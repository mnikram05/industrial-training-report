<x-form-section>
    <x-slot:labelText>{{ __('ui.live_preview') }}</x-slot:labelText>
    <x-landing.live-preview :preview-data="$previewData ?? []" />
</x-form-section>
