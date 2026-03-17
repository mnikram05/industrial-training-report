<div class="flex items-center justify-center gap-1">
    <button
        type="button"
        class="sort-btn inline-flex items-center justify-center size-7 rounded-md text-muted-foreground transition-colors hover:bg-accent hover:text-accent-foreground focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2"
        data-url="{{ route('reference.districts.update-sort', $district) }}"
        data-direction="up"
        title="{{ __('crud.move_up') }}"
    >
        <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="m18 15-6-6-6 6"/>
        </svg>
    </button>
    <button
        type="button"
        class="sort-btn inline-flex items-center justify-center size-7 rounded-md text-muted-foreground transition-colors hover:bg-accent hover:text-accent-foreground focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2"
        data-url="{{ route('reference.districts.update-sort', $district) }}"
        data-direction="down"
        title="{{ __('crud.move_down') }}"
    >
        <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="m6 9 6 6 6-6"/>
        </svg>
    </button>
</div>
