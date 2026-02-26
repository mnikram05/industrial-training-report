<button type="button" @click="accordionValue = accordionValue === itemValue ? null : itemValue"
    :aria-expanded="accordionValue === itemValue"
    {{ $attributes->merge(['class' => 'flex flex-1 items-start justify-between gap-4 rounded-md py-4 text-left text-sm font-medium transition-all hover:underline [&[aria-expanded=true]>svg]:rotate-180']) }}>
    <span>{{ $slot }}</span>
    <svg class="text-muted-foreground pointer-events-none size-4 shrink-0 translate-y-0.5 transition-transform duration-200"
        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
    </svg>
</button>
