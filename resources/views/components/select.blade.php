@props([
    'options' => [],
    'value' => null,
    'placeholder' => __('ui.select_an_option'),
])

@php
    $name = $attributes->get('name');
    $id = $attributes->get('id');
    $disabled = $attributes->has('disabled');
    $rootClass = trim((string) $attributes->get('class', ''));
    $normalizedOptions = [];

    foreach ($options as $optionValue => $optionLabel) {
        $normalizedOptions[(string) $optionValue] = (string) $optionLabel;
    }

    $selectedValue = is_scalar($value) ? (string) $value : '';
    $selectId =
        is_string($id) && $id !== ''
            ? $id
            : ($name
                ? str_replace(['[', ']', '.'], '_', (string) $name)
                : 'select_' . substr(md5(uniqid((string) random_int(0, 999999), true)), 0, 8));
@endphp

<div x-data="{
    open: false,
    selected: @js($selectedValue),
    options: @js($normalizedOptions),
    placeholder: @js($placeholder),
    get selectedLabel() {
        return this.options[this.selected] ?? '';
    },
    choose(optionValue) {
        const previousValue = this.selected;
        this.selected = optionValue;
        this.open = false;

        if (previousValue !== optionValue) {
            this.$dispatch('change', { value: optionValue });
        }
    },
}" {{ $attributes->except(['class', 'name', 'id', 'disabled']) }}
    class="{{ trim('relative w-full ' . $rootClass) }}" @keydown.escape.window="open = false">
    @if ($name)
        <input type="hidden" name="{{ $name }}" :value="selected">
    @endif

    <button type="button" id="{{ $selectId }}"
        class="border-input bg-background focus-visible:border-ring focus-visible:ring-ring/50 aria-invalid:ring-destructive/20 aria-invalid:border-destructive inline-flex h-9 w-full items-center justify-between rounded-md border px-3 py-1 text-sm shadow-xs transition-[color,box-shadow] outline-none focus-visible:ring-[3px] disabled:pointer-events-none disabled:cursor-not-allowed disabled:opacity-50"
        @click="open = !open" :aria-expanded="open.toString()" aria-haspopup="listbox" @disabled($disabled)>
        <span class="truncate" :class="selectedLabel ? 'text-foreground' : 'text-muted-foreground'"
            x-text="selectedLabel || placeholder"></span>
        <svg class="size-4 opacity-60" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6" />
        </svg>
    </button>

    <div x-show="open" x-cloak x-transition.origin.top.left @click.outside="open = false"
        class="bg-popover text-popover-foreground absolute z-50 mt-1 w-full min-w-[8rem] rounded-md border p-1 shadow-md">
        <div class="space-y-1">
            <template x-for="[optionValue, optionLabel] in Object.entries(options)" :key="optionValue">
                <button type="button"
                    class="flex w-full items-center justify-between rounded-sm px-2 py-1.5 text-left text-sm"
                    @click="choose(optionValue)"
                    :class="selected === optionValue ? 'bg-accent text-accent-foreground' :
                        'hover:bg-accent hover:text-accent-foreground'">
                    <span x-text="optionLabel"></span>
                    <svg x-show="selected === optionValue" x-cloak class="size-4" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                </button>
            </template>
        </div>
    </div>
</div>
