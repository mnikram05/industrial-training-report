@props([
    'checked' => false,
])

<button type="button" role="switch" x-data="{ on: @js((bool) $checked) }" @click="on = !on" :aria-checked="on"
    :data-state="on ? 'checked' : 'unchecked'"
    {{ $attributes->merge(['class' => 'peer data-[state=checked]:bg-primary data-[state=unchecked]:bg-input focus-visible:border-ring focus-visible:ring-ring/50 inline-flex h-[1.15rem] w-8 shrink-0 items-center rounded-full border border-transparent shadow-xs transition-all outline-none focus-visible:ring-[3px] disabled:cursor-not-allowed disabled:opacity-50']) }}>
    <span
        class="bg-background pointer-events-none block size-4 rounded-full ring-0 transition-transform data-[state=checked]:translate-x-[calc(100%-2px)] data-[state=unchecked]:translate-x-0"
        :data-state="on ? 'checked' : 'unchecked'"></span>
</button>
