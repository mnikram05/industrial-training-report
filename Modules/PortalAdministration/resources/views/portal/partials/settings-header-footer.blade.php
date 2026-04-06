{{-- Logo portal awam — logo CMS di skrin Tetapan CMS --}}
<div
    x-data="{
        logoPreview: @js(! empty($settings['logo_path']) ? Storage::disk('public')->url($settings['logo_path']) : ''),
    }">
    <h3 class="mb-3 text-sm font-semibold uppercase tracking-wide text-muted-foreground">{{ __('modules/portal-administration/portal-setting.sections.logo') }}</h3>
    <div class="space-y-3">
        <p class="text-xs font-medium text-muted-foreground">{{ __('modules/portal-administration/portal-setting.fields.portal_public_logo') }}</p>
        <div class="flex flex-wrap items-center gap-4">
            <img x-show="logoPreview" :src="logoPreview" alt="" class="shrink-0 rounded border bg-white object-contain p-1" style="max-height: 48px; max-width: 192px" />
            <p x-show="logoPreview" class="text-xs text-muted-foreground">{{ __('modules/portal-administration/portal-setting.hints.logo_portal_preview') }}</p>
            <p x-show="!logoPreview" class="text-xs italic text-muted-foreground">{{ __('modules/portal-administration/portal-setting.messages.none') }}</p>
        </div>
        <x-field for="logo_path" class="gap-1.5">
            <x-slot:labelText>{{ __('modules/portal-administration/portal-setting.fields.select_logo') }}</x-slot:labelText>
            <select id="logo_path" name="logo_path" class="h-9 rounded-md border border-input bg-background px-3 text-sm sm:w-1/2"
                @change="logoPreview = $el.value ? '/storage/' + $el.value : ''">
                <option value="">-- {{ __('modules/portal-administration/portal-setting.messages.none') }} --</option>
                @foreach ($mediaOptions as $path => $label)
                    <option value="{{ $path }}" {{ ($settings['logo_path'] ?? '') === $path ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
            <p class="text-xs text-muted-foreground">{{ __('modules/portal-administration/portal-setting.hints.upload_media_first') }}</p>
        </x-field>
    </div>
</div>

<hr />

{{-- Menu Navigation --}}
<div>
    <h3 class="mb-3 text-sm font-semibold uppercase tracking-wide text-muted-foreground">{{ __('modules/portal-administration/portal-setting.sections.nav_menu') }}</h3>
    <div class="grid gap-4 sm:grid-cols-2">
        <x-field for="menu_atas_id" class="gap-1.5">
            <x-slot:labelText>{{ __('modules/portal-administration/portal-setting.fields.top_menu') }}</x-slot:labelText>
            <select id="menu_atas_id" name="menu_atas_id" class="h-9 rounded-md border border-input bg-background px-3 text-sm sm:w-full">
                <option value="">-- {{ __('modules/portal-administration/portal-setting.fields.select_menu') }} --</option>
                @foreach ($parentMenus as $parentMenu)
                    <option value="{{ $parentMenu->id }}" {{ ($settings['menu_atas_id'] ?? '') == $parentMenu->id ? 'selected' : '' }}>
                        {{ $parentMenu->title_ms }} / {{ $parentMenu->title_en }}
                    </option>
                @endforeach
            </select>
            <p class="text-xs text-muted-foreground">{{ __('modules/portal-administration/portal-setting.hints.top_menu_hint') }}</p>
        </x-field>
        <x-field for="menu_bawah_id" class="gap-1.5">
            <x-slot:labelText>{{ __('modules/portal-administration/portal-setting.fields.footer_menu') }}</x-slot:labelText>
            <select id="menu_bawah_id" name="menu_bawah_id" class="h-9 rounded-md border border-input bg-background px-3 text-sm sm:w-full">
                <option value="">-- {{ __('modules/portal-administration/portal-setting.fields.select_menu') }} --</option>
                @foreach ($parentMenus as $parentMenu)
                    <option value="{{ $parentMenu->id }}" {{ ($settings['menu_bawah_id'] ?? '') == $parentMenu->id ? 'selected' : '' }}>
                        {{ $parentMenu->title_ms }} / {{ $parentMenu->title_en }}
                    </option>
                @endforeach
            </select>
            <p class="text-xs text-muted-foreground">{{ __('modules/portal-administration/portal-setting.hints.footer_menu_hint') }}</p>
        </x-field>
    </div>
</div>

<hr />

{{-- Site Name --}}
<div>
    <h3 class="mb-3 text-sm font-semibold uppercase tracking-wide text-muted-foreground">{{ __('modules/portal-administration/portal-setting.sections.site_name') }}</h3>
    <div class="grid gap-4 sm:grid-cols-2">
        <x-field for="site_name_ms" class="gap-1.5">
            <x-slot:labelText>{{ __('modules/portal-administration/portal-setting.fields.site_name_ms') }}</x-slot:labelText>
            <x-input id="site_name_ms" name="site_name_ms" type="text"
                :value="$settings['site_name_ms'] ?? ''" />
        </x-field>
        <x-field for="site_name_en" class="gap-1.5">
            <x-slot:labelText>{{ __('modules/portal-administration/portal-setting.fields.site_name_en') }}</x-slot:labelText>
            <x-input id="site_name_en" name="site_name_en" type="text"
                :value="$settings['site_name_en'] ?? ''" />
        </x-field>
    </div>
</div>

<hr />

{{-- Footer Text --}}
<div>
    <h3 class="mb-3 text-sm font-semibold uppercase tracking-wide text-muted-foreground">{{ __('modules/portal-administration/portal-setting.sections.footer_text') }}</h3>
    <div class="grid gap-4 sm:grid-cols-2">
        <x-field for="footer_text_ms" class="gap-1.5">
            <x-slot:labelText>{{ __('modules/portal-administration/portal-setting.fields.footer_text_ms') }}</x-slot:labelText>
            <x-input id="footer_text_ms" name="footer_text_ms" type="text"
                :value="$settings['footer_text_ms'] ?? ''" />
        </x-field>
        <x-field for="footer_text_en" class="gap-1.5">
            <x-slot:labelText>{{ __('modules/portal-administration/portal-setting.fields.footer_text_en') }}</x-slot:labelText>
            <x-input id="footer_text_en" name="footer_text_en" type="text"
                :value="$settings['footer_text_en'] ?? ''" />
        </x-field>
    </div>
</div>

<hr />

<p class="mb-3 text-xs text-muted-foreground">{{ __('modules/portal-administration/portal-setting.hints.portal_colors_only') }}</p>

@include('portaladministration::portal.partials.settings-colors')
