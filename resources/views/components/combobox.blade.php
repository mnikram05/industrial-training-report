@props([
    'options' => [],
    'value' => null,
    'placeholder' => __('ui.select_an_option'),
    'searchPlaceholder' => __('Search...'),
])

@php
    $name = $attributes->get('name');
    $id = $attributes->get('id');
    $disabled = $attributes->has('disabled');
    $rootClass = trim((string) $attributes->get('class', ''));
    $normalizedOptions = [];

    foreach ($options as $optionValue => $optionLabel) {
        if (is_array($optionLabel)) {
            $resolvedValue = $optionLabel['value'] ?? $optionValue;
            $resolvedLabel = $optionLabel['label'] ?? ($optionLabel['value'] ?? $optionValue);

            $normalizedOptions[(string) $resolvedValue] = (string) $resolvedLabel;

            continue;
        }

        $normalizedOptions[(string) $optionValue] = (string) $optionLabel;
    }

    $selectedValue = is_scalar($value) ? (string) $value : '';
    $comboboxId =
        is_string($id) && $id !== ''
            ? $id
            : ($name
                ? str_replace(['[', ']', '.'], '_', (string) $name)
                : 'combobox_' . substr(md5(uniqid((string) random_int(0, 999999), true)), 0, 8));
@endphp

<div x-data="{
    open: false,
    query: '',
    selected: @js($selectedValue),
    options: @js($normalizedOptions),
    placeholder: @js($placeholder),
    searchPlaceholder: @js($searchPlaceholder),
    noResultsLabel: @js(__('No results found.')),
    get selectedLabel() {
        return this.options[this.selected] ?? '';
    },
    get filteredOptions() {
        if (this.query.trim() === '') {
            return Object.entries(this.options);
        }

        const term = this.query.toLowerCase();

        return Object.entries(this.options).filter(([optionValue, optionLabel]) => {
            return optionLabel.toLowerCase().includes(term) || optionValue.toLowerCase().includes(term);
        });
    },
    choose(optionValue) {
        const previousValue = this.selected;

        this.selected = optionValue;
        this.open = false;
        this.query = '';

        if (previousValue !== optionValue) {
            this.$nextTick(() => {
                this.$dispatch('change', { value: optionValue });
            });
        }
    },
}" {{ $attributes->except(['class', 'name', 'id', 'disabled']) }}
    class="{{ trim('relative w-full min-w-0 ' . $rootClass) }}" @keydown.escape.window="open = false"
    x-effect="if (open) { $nextTick(() => $refs.searchInput?.focus()); }">
    @if ($name)
        <input type="hidden" name="{{ $name }}" :value="selected">
    @endif

    <button type="button" id="{{ $comboboxId }}"
        class="border-input bg-background focus-visible:border-ring focus-visible:ring-ring/50 aria-invalid:ring-destructive/20 aria-invalid:border-destructive inline-flex h-9 w-full min-w-0 items-center justify-between gap-2 rounded-md border px-3 py-1 text-sm shadow-xs transition-[color,box-shadow] outline-none focus-visible:ring-[3px] disabled:pointer-events-none disabled:cursor-not-allowed disabled:opacity-50"
        @click="open = !open" :aria-expanded="open.toString()" aria-haspopup="listbox" @disabled($disabled)>
        <span class="truncate" :class="selectedLabel ? 'text-foreground' : 'text-muted-foreground'"
            x-text="selectedLabel || placeholder"></span>
        <svg class="size-4 shrink-0 opacity-60" viewBox="0 0 24 24" fill="none" stroke="currentColor"
            stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6" />
        </svg>
    </button>

    <div x-show="open" x-cloak x-transition.origin.top.left @click.outside="open = false"
        class="bg-popover text-popover-foreground absolute left-0 z-50 mt-1 w-full max-w-full rounded-md border p-1 shadow-md">
        <div class="p-1">
            <x-input x-ref="searchInput" x-model="query" type="text" class="h-8 w-full" ::placeholder="searchPlaceholder" />
        </div>
        <div class="max-h-60 space-y-1 overflow-y-auto p-1" role="listbox" :aria-labelledby="'{{ $comboboxId }}'">
            <template x-if="filteredOptions.length === 0">
                <p class="px-2 py-1.5 text-sm text-muted-foreground" x-text="noResultsLabel"></p>
            </template>

            <template x-for="[optionValue, optionLabel] in filteredOptions" :key="optionValue">
                <button type="button" @click="choose(optionValue)"
                    class="flex w-full items-center justify-between rounded-sm px-2 py-1.5 text-left text-sm"
                    :class="selected === optionValue ? 'bg-accent text-accent-foreground' :
                        'hover:bg-accent hover:text-accent-foreground'">
                    <span class="truncate" x-text="optionLabel"></span>
                    <svg x-show="selected === optionValue" x-cloak class="size-4 shrink-0" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                </button>
            </template>
        </div>
    </div>
</div>
