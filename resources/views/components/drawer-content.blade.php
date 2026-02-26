<div x-show="open" x-cloak class="fixed inset-0 z-50 flex items-end" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-black/50" @click="open = false"></div>
    <div x-show="open" x-transition:enter="duration-200 ease-out" x-transition:enter-start="translate-y-full"
        x-transition:enter-end="translate-y-0" x-transition:leave="duration-150 ease-in"
        x-transition:leave-start="translate-y-0" x-transition:leave-end="translate-y-full"
        {{ $attributes->merge(['class' => 'bg-background relative z-10 w-full rounded-t-xl border p-6 shadow-lg']) }}>
        {{ $slot }}
    </div>
</div>
