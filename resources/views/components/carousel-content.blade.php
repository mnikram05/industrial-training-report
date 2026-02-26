<div {{ $attributes->merge(['class' => 'overflow-hidden']) }}>
    <div class="flex -ml-4">
        {{ $slot }}
    </div>
</div>
