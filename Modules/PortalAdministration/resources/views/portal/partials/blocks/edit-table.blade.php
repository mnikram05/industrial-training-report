<div class="space-y-4">
    <div class="grid gap-4 sm:grid-cols-2">
        <x-field class="gap-1.5"><x-slot:labelText>{{ __('modules/portal/setting.fields.title_my') }}</x-slot:labelText>
            <x-input type="text" x-model="block.data.heading_ms" /></x-field>
        <x-field class="gap-1.5"><x-slot:labelText>{{ __('modules/portal/setting.fields.title_en') }}</x-slot:labelText>
            <x-input type="text" x-model="block.data.heading_en" /></x-field>
    </div>

    {{-- Columns --}}
    <div class="rounded border bg-gray-50/50 p-3 space-y-2">
        <div class="flex items-center justify-between">
            <p class="text-xs font-semibold text-muted-foreground">{{ __('modules/portal/setting.fields.columns') }}</p>
            <button type="button" @click="if(!block.data.columns_ms) block.data.columns_ms=[]; if(!block.data.columns_en) block.data.columns_en=[]; block.data.columns_ms.push(''); block.data.columns_en.push('')" class="text-xs text-foreground/70 hover:text-foreground">+ {{ __('modules/portal/setting.actions.add') }}</button>
        </div>
        <template x-for="(col, ci) in (block.data.columns_ms || [])" :key="ci">
            <div class="flex items-start gap-2">
                <div class="grid flex-1 gap-2 sm:grid-cols-2">
                    <x-input type="text" x-model="block.data.columns_ms[ci]" placeholder="MY" />
                    <x-input type="text" x-model="block.data.columns_en[ci]" placeholder="EN" />
                </div>
                <button type="button" @click="block.data.columns_ms.splice(ci, 1); block.data.columns_en.splice(ci, 1)" class="mt-1.5 text-destructive"><svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/></svg></button>
            </div>
        </template>
    </div>

    {{-- Rows --}}
    <div class="rounded border bg-gray-50/50 p-3 space-y-2">
        <div class="flex items-center justify-between">
            <p class="text-xs font-semibold text-muted-foreground">{{ __('modules/portal/setting.fields.table_rows') }}</p>
            <button type="button" @click="const cols = (block.data.columns_ms || []).length || 3; const row = {}; for(let i=0;i<cols;i++) row['col_'+i]=''; block.data.rows.push(row)" class="text-xs text-foreground/70 hover:text-foreground">+ {{ __('modules/portal/setting.actions.add') }}</button>
        </div>
        <template x-for="(row, ri) in block.data.rows" :key="ri">
            <div class="flex items-start gap-2">
                <span class="mt-2 text-xs text-muted-foreground" x-text="ri + 1"></span>
                <div class="grid flex-1 gap-2" :style="'grid-template-columns: repeat(' + Object.keys(row).length + ', 1fr)'">
                    <template x-for="(val, key) in row" :key="key">
                        <x-input type="text" x-model="row[key]" />
                    </template>
                </div>
                <button type="button" @click="block.data.rows.splice(ri, 1)" class="mt-1.5 text-destructive"><svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/></svg></button>
            </div>
        </template>
    </div>
</div>
