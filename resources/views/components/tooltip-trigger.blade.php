<div @mouseenter="open = true" @mouseleave="open = false" @focusin="open = true" @focusout="open = false"
    {{ $attributes }}>
    {{ $slot }}
</div>
