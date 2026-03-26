@php
    $blockTypes = [
        'hero'              => __('modules/portal/setting.block_types.hero'),
        'cards'             => __('modules/portal/setting.block_types.cards'),
        'text'              => __('modules/portal/setting.block_types.text'),
        'image'             => __('modules/portal/setting.block_types.image'),
        'list'              => __('modules/portal/setting.block_types.list'),
        'two-column-cards'  => __('modules/portal/setting.block_types.two_column_cards'),
        'grid-cards'        => __('modules/portal/setting.block_types.grid_cards'),
        'table'             => __('modules/portal/setting.block_types.table'),
        'cta'               => __('modules/portal/setting.block_types.cta'),
        'quick-nav'         => __('modules/portal/setting.block_types.quick_nav'),
        'profile-card'      => __('modules/portal/setting.block_types.profile_card'),
        'weekly-grid'       => __('modules/portal/setting.block_types.weekly_grid'),
        'daily-log'         => __('modules/portal/setting.block_types.daily_log'),
        'task-showcase'     => __('modules/portal/setting.block_types.task_showcase'),
    ];

    $blockDefaults = [
        'hero'             => ['title_ms' => '', 'title_en' => '', 'subtitle_ms' => '', 'subtitle_en' => '', 'institution_ms' => '', 'institution_en' => '', 'session_ms' => '', 'session_en' => '', 'subtitle2_ms' => '', 'subtitle2_en' => '', 'address' => ''],
        'cards'            => ['layout' => 'centered', 'items' => []],
        'text'             => ['icon' => '', 'heading_ms' => '', 'heading_en' => '', 'text_ms' => '', 'text_en' => ''],
        'image'            => ['image_path' => '', 'caption_ms' => '', 'caption_en' => ''],
        'list'             => ['icon' => '', 'heading_ms' => '', 'heading_en' => '', 'items_ms' => [], 'items_en' => []],
        'two-column-cards' => ['icon' => '', 'heading_ms' => '', 'heading_en' => '', 'cards' => []],
        'grid-cards'       => ['icon' => '', 'heading_ms' => '', 'heading_en' => '', 'items' => []],
        'table'            => ['heading_ms' => '', 'heading_en' => '', 'columns_ms' => [], 'columns_en' => [], 'rows' => []],
        'cta'              => ['text_ms' => '', 'text_en' => '', 'button_text_ms' => '', 'button_text_en' => '', 'url' => ''],
        'quick-nav'        => ['heading_ms' => '', 'heading_en' => '', 'items' => []],
        'profile-card'     => ['photo_path' => '', 'nama' => '', 'no_pelajar' => '', 'program' => '', 'program_ms' => '', 'program_en' => '', 'sesi_latihan' => '', 'tempoh_li' => '', 'tarikh_lahir' => '', 'telefon' => '', 'email' => '', 'alamat' => ''],
        'weekly-grid'      => ['heading_ms' => '', 'heading_en' => '', 'items' => []],
        'daily-log'        => ['icon' => '', 'heading_ms' => '', 'heading_en' => '', 'days' => []],
        'task-showcase'    => ['heading_ms' => '', 'heading_en' => '', 'items' => []],
    ];
@endphp

<div x-data="{
    blocks: @js($blocks),
    blockTypes: @js($blockTypes),
    blockDefaults: @js($blockDefaults),
    mediaOptions: @js($mediaOptions),
    expanded: {},

    addBlock(type) {
        const id = 'blk_' + Date.now() + '_' + Math.random().toString(36).slice(2,7);
        const defaults = JSON.parse(JSON.stringify(this.blockDefaults[type] || {}));
        this.blocks.push({ type, id, data: defaults });
        this.expanded[id] = true;
    },
    removeBlock(index) {
        if (confirm('{{ __('modules/portal/setting.actions.confirm_remove') }}')) {
            this.blocks.splice(index, 1);
        }
    },
    moveUp(index) {
        if (index > 0) {
            [this.blocks[index], this.blocks[index - 1]] = [this.blocks[index - 1], this.blocks[index]];
        }
    },
    moveDown(index) {
        if (index < this.blocks.length - 1) {
            [this.blocks[index], this.blocks[index + 1]] = [this.blocks[index + 1], this.blocks[index]];
        }
    },
    toggleExpand(id) {
        this.expanded[id] = !this.expanded[id];
    }
}">
    <input type="hidden" name="blocks" :value="JSON.stringify(blocks)" />

    {{-- Add Block --}}
    <div class="mb-6 flex items-center gap-3">
        <select x-ref="blockTypeSelect" class="h-9 rounded-md border border-input bg-background px-3 text-sm">
            <option value="">-- {{ __('modules/portal/setting.actions.select_block') }} --</option>
            <template x-for="[type, label] in Object.entries(blockTypes)" :key="type">
                <option :value="type" x-text="label"></option>
            </template>
        </select>
        <button type="button" @click="if($refs.blockTypeSelect.value) { addBlock($refs.blockTypeSelect.value); $refs.blockTypeSelect.value = ''; }"
            class="inline-flex items-center gap-1.5 rounded-md bg-primary px-4 py-2 text-xs font-medium text-primary-foreground transition-colors hover:bg-primary/90">
            <svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
            </svg>
            {{ __('modules/portal/setting.actions.add_block') }}
        </button>
    </div>

    {{-- Block List --}}
    <div class="space-y-3">
        <template x-for="(block, index) in blocks" :key="block.id">
            <div class="rounded-lg border">
                {{-- Block Header --}}
                <div class="flex items-center justify-between rounded-t-lg bg-gray-50 px-4 py-3">
                    <div class="flex items-center gap-3">
                        <span class="text-xs font-bold text-muted-foreground" x-text="index + 1"></span>
                        <span class="rounded bg-primary/10 px-2 py-0.5 text-xs font-semibold text-primary" x-text="blockTypes[block.type] || block.type"></span>
                    </div>
                    <div class="flex items-center gap-1">
                        <button type="button" @click="moveUp(index)" :disabled="index === 0"
                            class="rounded p-1.5 text-muted-foreground transition-colors hover:bg-accent hover:text-foreground disabled:opacity-30">
                            <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 15.75 7.5-7.5 7.5 7.5"/></svg>
                        </button>
                        <button type="button" @click="moveDown(index)" :disabled="index === blocks.length - 1"
                            class="rounded p-1.5 text-muted-foreground transition-colors hover:bg-accent hover:text-foreground disabled:opacity-30">
                            <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5"/></svg>
                        </button>
                        <button type="button" @click="toggleExpand(block.id)"
                            class="rounded p-1.5 text-muted-foreground transition-colors hover:bg-accent hover:text-foreground">
                            <svg class="size-4 transition-transform" :class="expanded[block.id] && 'rotate-180'" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5"/></svg>
                        </button>
                        <button type="button" @click="removeBlock(index)"
                            class="rounded p-1.5 text-destructive transition-colors hover:bg-destructive/10">
                            <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                </div>

                {{-- Block Body (expandable) --}}
                <div x-show="expanded[block.id]" x-transition class="space-y-4 p-4">
                    <template x-if="block.type === 'hero'">
                        @include('portaladministration::portal.partials.blocks.edit-hero')
                    </template>
                    <template x-if="block.type === 'cards'">
                        @include('portaladministration::portal.partials.blocks.edit-cards')
                    </template>
                    <template x-if="block.type === 'text'">
                        @include('portaladministration::portal.partials.blocks.edit-text')
                    </template>
                    <template x-if="block.type === 'image'">
                        @include('portaladministration::portal.partials.blocks.edit-image')
                    </template>
                    <template x-if="block.type === 'list'">
                        @include('portaladministration::portal.partials.blocks.edit-list')
                    </template>
                    <template x-if="block.type === 'two-column-cards'">
                        @include('portaladministration::portal.partials.blocks.edit-two-column-cards')
                    </template>
                    <template x-if="block.type === 'grid-cards'">
                        @include('portaladministration::portal.partials.blocks.edit-grid-cards')
                    </template>
                    <template x-if="block.type === 'table'">
                        @include('portaladministration::portal.partials.blocks.edit-table')
                    </template>
                    <template x-if="block.type === 'cta'">
                        @include('portaladministration::portal.partials.blocks.edit-cta')
                    </template>
                    <template x-if="block.type === 'quick-nav'">
                        @include('portaladministration::portal.partials.blocks.edit-quick-nav')
                    </template>
                    <template x-if="block.type === 'profile-card'">
                        @include('portaladministration::portal.partials.blocks.edit-profile-card')
                    </template>
                    <template x-if="block.type === 'weekly-grid'">
                        @include('portaladministration::portal.partials.blocks.edit-weekly-grid')
                    </template>
                    <template x-if="block.type === 'daily-log'">
                        @include('portaladministration::portal.partials.blocks.edit-daily-log')
                    </template>
                    <template x-if="block.type === 'task-showcase'">
                        @include('portaladministration::portal.partials.blocks.edit-task-showcase')
                    </template>
                </div>
            </div>
        </template>

        <p x-show="blocks.length === 0" class="py-8 text-center text-sm text-muted-foreground">
            {{ __('modules/portal/setting.actions.no_blocks') }}
        </p>
    </div>
</div>

<hr />

@include('portaladministration::portal.partials.settings-colors')
