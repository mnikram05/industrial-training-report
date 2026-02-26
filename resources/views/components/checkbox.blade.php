@props([
    'checked' => false,
])

<input type="checkbox" @checked($checked)
    {{ $attributes->merge(['class' => 'border-input accent-black text-black dark:bg-input/30 checked:border-black checked:bg-black data-[state=checked]:bg-black data-[state=checked]:text-white focus-visible:border-ring focus-visible:ring-ring/50 aria-invalid:ring-destructive/20 dark:aria-invalid:ring-destructive/40 aria-invalid:border-destructive size-4 shrink-0 rounded-[4px] border shadow-xs transition-shadow outline-none focus-visible:ring-[3px] disabled:cursor-not-allowed disabled:opacity-50']) }}>
