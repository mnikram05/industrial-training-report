<div @contextmenu.prevent="open = true; x = $event.clientX; y = $event.clientY" @click="open = false" {{ $attributes }}>
    {{ $slot }}
</div>
