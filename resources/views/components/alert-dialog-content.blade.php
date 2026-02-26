<div x-show="open" x-cloak class="fixed inset-0 z-50 grid place-items-center p-4" role="alertdialog" aria-modal="true">
    <div class="fixed inset-0 bg-black/50" @click="open = false"></div>
    <div x-show="open" x-transition:enter="duration-200 ease-out" x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100" x-transition:leave="duration-150 ease-in"
        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
        {{ $attributes->merge(['class' => 'bg-background fixed top-[50%] left-[50%] z-50 grid w-full max-w-[calc(100%-2rem)] translate-x-[-50%] translate-y-[-50%] gap-4 rounded-lg border p-6 shadow-lg duration-200 sm:max-w-lg']) }}>
        {{ $slot }}
    </div>
</div>
