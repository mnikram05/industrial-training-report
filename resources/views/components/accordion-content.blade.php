<div x-show="accordionValue === itemValue" x-collapse x-cloak
    {{ $attributes->merge(['class' => 'overflow-hidden text-sm']) }}>
    <div class="pb-4 pt-0">
        {{ $slot }}
    </div>
</div>
