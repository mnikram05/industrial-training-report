@props([
    'length' => 6,
    'name' => 'otp',
])

<div x-data="{ value: Array({{ (int) $length }}).fill('') }" {{ $attributes->merge(['class' => 'flex items-center gap-2']) }}>
    <input type="hidden" name="{{ $name }}" :value="value.join('')">
    @for ($i = 0; $i < (int) $length; $i++)
        <input type="text" inputmode="numeric" maxlength="1" x-model="value[{{ $i }}]"
            class="border-input focus-visible:border-ring focus-visible:ring-ring/50 size-9 rounded-md border text-center text-sm outline-none focus-visible:ring-[3px]">
    @endfor
</div>
