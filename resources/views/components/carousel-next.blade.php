<x-button variant="outline" size="icon" type="button"
    {{ $attributes->merge(['class' => 'absolute right-2 top-1/2 -translate-y-1/2']) }}>
    {{ $slot ?: '›' }}
</x-button>
