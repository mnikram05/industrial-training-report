@props([
    'name' => null,
    'value' => null,
    'checked' => false,
])

<input type="radio" @if ($name) name="{{ $name }}" @endif
    @if (!is_null($value)) value="{{ $value }}" @endif @checked($checked)
    {{ $attributes->merge(['class' => 'aspect-square border-input text-primary focus-visible:border-ring focus-visible:ring-ring/50 aria-invalid:ring-destructive/20 dark:aria-invalid:ring-destructive/40 aria-invalid:border-destructive size-4 shrink-0 rounded-full border shadow-xs transition-[color,box-shadow] outline-none focus-visible:ring-[3px] disabled:cursor-not-allowed disabled:opacity-50']) }}>
