<button type="button" @click="open = false"
    {{ $attributes->merge(['class' => 'ring-offset-background focus:ring-ring data-[state=open]:bg-accent data-[state=open]:text-muted-foreground absolute top-4 right-4 rounded-xs opacity-70 transition-opacity hover:opacity-100 focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:pointer-events-none']) }}>
    {{ $slot }}
</button>
