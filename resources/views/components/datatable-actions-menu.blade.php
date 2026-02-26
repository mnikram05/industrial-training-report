@props([
    'items' => [],
    'menuWidthClass' => 'w-32',
])

@php
    $hasSlotItems = isset($slot) && $slot->hasActualContent();
    $normalizedItems = $hasSlotItems
        ? []
        : collect($items)
            ->map(static function ($item): array {
                return [
                    'label' => (string) data_get($item, 'label', ''),
                    'href' => (string) data_get($item, 'href', '#'),
                    'target' => data_get($item, 'target'),
                ];
            })
            ->filter(static fn(array $item): bool => $item['label'] !== '' && $item['href'] !== '')
            ->values()
            ->all();
@endphp

<div class="flex justify-end">
    <div x-data="{
        open: false,
        menuStyles: '',
        toggleMenu() {
            if (this.open) {
                this.closeMenu();
                return;
            }
    
            this.open = true;
            this.$nextTick(() => this.positionMenu());
        },
        positionMenu() {
            const trigger = this.$refs.trigger;
            const menu = this.$refs.menu;
    
            if (!trigger || !menu) {
                return;
            }
    
            const triggerRect = trigger.getBoundingClientRect();
            const menuWidth = menu.offsetWidth || 128;
            const menuHeight = menu.offsetHeight || 56;
            const viewportWidth = window.innerWidth;
            const viewportHeight = window.innerHeight;
            const gap = 8;
    
            let left = triggerRect.right - menuWidth;
            left = Math.max(gap, Math.min(left, viewportWidth - menuWidth - gap));
    
            let top = triggerRect.bottom + gap;
            if (top + menuHeight > viewportHeight - gap) {
                top = triggerRect.top - menuHeight - gap;
            }
            top = Math.max(gap, top);
    
            this.menuStyles = `left: ${left}px; top: ${top}px;`;
        },
        closeMenu() {
            this.open = false;
        },
    }" class="relative inline-flex" @keydown.escape.window="closeMenu()"
        @scroll.window="if (open) { positionMenu(); }" @resize.window="if (open) { positionMenu(); }">
        <button x-ref="trigger" type="button"
            class="inline-flex h-8 w-8 items-center justify-center rounded-md hover:bg-accent" @click="toggleMenu()"
            aria-haspopup="true" :aria-expanded="open.toString()">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-muted-foreground" viewBox="0 0 24 24"
                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                aria-hidden="true">
                <circle cx="12" cy="12" r="1"></circle>
                <circle cx="19" cy="12" r="1"></circle>
                <circle cx="5" cy="12" r="1"></circle>
            </svg>
        </button>

        <template x-teleport="body">
            <div x-cloak x-show="open" x-ref="menu" @click.outside="closeMenu()" x-transition.opacity.duration.150ms
                :style="menuStyles"
                class="bg-popover text-popover-foreground fixed z-[100] {{ $menuWidthClass }} rounded-md border border-border p-1 shadow-md">
                @if ($hasSlotItems)
                    {{ $slot }}
                @else
                    @foreach ($normalizedItems as $item)
                        <x-datatable-action-link :href="$item['href']" :target="$item['target']">
                            {{ $item['label'] }}
                        </x-datatable-action-link>
                    @endforeach
                @endif
            </div>
        </template>
    </div>
</div>
