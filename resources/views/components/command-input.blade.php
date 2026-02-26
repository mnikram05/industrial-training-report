<div class="flex h-9 items-center gap-2 border-b px-3" data-slot="command-input-wrapper">
    <svg class="size-4 shrink-0 opacity-50" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
        stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.34-4.34" />
        <circle cx="11" cy="11" r="8" />
    </svg>
    <input
        {{ $attributes->merge(['class' => 'flex h-8 w-full rounded-md bg-transparent py-3 text-sm outline-none placeholder:text-muted-foreground disabled:cursor-not-allowed disabled:opacity-50']) }}>
</div>
