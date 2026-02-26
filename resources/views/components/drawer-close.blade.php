<button type="button" @click="open = false"
    {{ $attributes->merge(['class' => 'ring-offset-background focus:ring-ring rounded-xs p-1 opacity-70 transition-opacity hover:opacity-100 focus:outline-none focus:ring-2 focus:ring-offset-2']) }}>
    {{ $slot }}
</button>
