{{-- Tetapan khas CMS (page `cms` dalam portal_settings) --}}
<div
    x-data="{
        cmsLogoPreview: @js(! empty($settings['cms_logo_path']) ? Storage::disk('public')->url($settings['cms_logo_path']) : ''),
    }">
    <h3 class="mb-3 text-sm font-semibold uppercase tracking-wide text-muted-foreground">{{ __('modules/portal-administration/portal-setting.sections.logo') }}
        — {{ __('modules/portal-administration/portal-setting.pages.cms') }}</h3>
    <div class="space-y-3">
        <p class="text-xs font-medium text-muted-foreground">{{ __('modules/portal-administration/portal-setting.fields.cms_admin_logo') }}</p>
        <div class="flex flex-wrap items-center gap-4">
            <img x-show="cmsLogoPreview" :src="cmsLogoPreview" alt="" class="shrink-0 rounded border bg-white object-contain p-1" style="max-height: 48px; max-width: 192px" />
            <p x-show="cmsLogoPreview" class="text-xs text-muted-foreground">{{ __('modules/portal-administration/portal-setting.hints.logo_cms_preview') }}</p>
            <p x-show="!cmsLogoPreview" class="text-xs italic text-muted-foreground">{{ __('modules/portal-administration/portal-setting.hints.logo_cms_fallback') }}</p>
        </div>
        <x-field for="cms_logo_path" class="gap-1.5">
            <x-slot:labelText>{{ __('modules/portal-administration/portal-setting.fields.select_cms_logo') }}</x-slot:labelText>
            <select id="cms_logo_path" name="cms_logo_path" class="h-9 rounded-md border border-input bg-background px-3 text-sm sm:w-1/2"
                @change="cmsLogoPreview = $el.value ? '/storage/' + $el.value : ''">
                <option value="">-- {{ __('modules/portal-administration/portal-setting.messages.none') }} --</option>
                @foreach ($mediaOptions as $path => $label)
                    <option value="{{ $path }}" {{ ($settings['cms_logo_path'] ?? '') === $path ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
            <p class="text-xs text-muted-foreground">{{ __('modules/portal-administration/portal-setting.hints.cms_logo_help') }}</p>
        </x-field>
    </div>
</div>

<hr />

<div>
    <h3 class="mb-3 text-sm font-semibold uppercase tracking-wide text-muted-foreground">{{ __('modules/portal-administration/portal-setting.sections.cms_footer') }}</h3>
    <div class="grid gap-4 sm:grid-cols-2">
        <x-field for="cms_footer_ms" class="gap-1.5">
            <x-slot:labelText>{{ __('modules/portal-administration/portal-setting.fields.cms_footer_ms') }}</x-slot:labelText>
            <x-input id="cms_footer_ms" name="cms_footer_ms" type="text" :value="$settings['cms_footer_ms'] ?? ''" />
        </x-field>
        <x-field for="cms_footer_en" class="gap-1.5">
            <x-slot:labelText>{{ __('modules/portal-administration/portal-setting.fields.cms_footer_en') }}</x-slot:labelText>
            <x-input id="cms_footer_en" name="cms_footer_en" type="text" :value="$settings['cms_footer_en'] ?? ''" />
        </x-field>
    </div>
    <p class="mt-2 text-xs text-muted-foreground">{{ __('modules/portal-administration/portal-setting.hints.cms_footer_help') }}</p>
</div>

<hr />

<p class="mb-3 text-xs text-muted-foreground">{{ __('modules/portal-administration/portal-setting.hints.cms_colors_only') }}</p>

@include('portaladministration::portal.partials.settings-cms-colors')
