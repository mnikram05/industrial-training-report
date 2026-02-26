<span @click="open = true" {{ $attributes->merge(['class' => 'contents']) }}>
    {{ $slot }}
</span>
