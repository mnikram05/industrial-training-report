<button type="button"
    {{ $attributes->merge(['class' => 'ring-offset-background focus:ring-ring absolute top-2 right-2 rounded-xs p-1 opacity-70 transition-opacity hover:opacity-100 focus:outline-none focus:ring-2 focus:ring-offset-2']) }}>
    {{ $slot ?: '×' }}
</button>
