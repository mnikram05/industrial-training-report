@props([
    /** @var string 'landing' | 'content' */
    'variant' => 'content',
])

<div id="portal-skeleton" class="portal-skeleton" role="status" aria-live="polite" aria-busy="true" aria-label="{{ __('ui.loading') }}">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <x-portal.skeleton-header />
        @if ($variant === 'landing')
            <x-portal.skeleton-body-landing />
        @else
            <x-portal.skeleton-body-content />
        @endif
    </div>
</div>
