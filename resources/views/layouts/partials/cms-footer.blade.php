@php
    $locale = app()->getLocale();
    $cmsKey = $locale === 'ms' ? 'cms_footer_ms' : 'cms_footer_en';
    $portalFooterKey = 'footer_text_'.$locale;

    $customCms = \Modules\PortalAdministration\Models\PortalSetting::getValue($cmsKey, null, 'cms');
    $portalLine = \Modules\PortalAdministration\Models\PortalSetting::getValue($portalFooterKey, null, 'header-footer')
        ?? \Modules\PortalAdministration\Models\PortalSetting::getValue($portalFooterKey);

    $footerLine = is_string($customCms) && $customCms !== ''
        ? $customCms
        : (is_string($portalLine) && $portalLine !== ''
            ? $portalLine
            : __('cms.footer.fallback', ['year' => date('Y'), 'app' => config('app.name')]));
@endphp
{{-- Rujuk Modules/Portal/resources/views/layout.blade.php — footer portal --}}
<footer class="admin-cms-footer relative text-gray-400" style="background-color: var(--portal-footer-bg)" role="contentinfo">
    <div class="h-1" style="background-color: var(--portal-accent)"></div>

    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
        <div class="text-center">
            <p class="text-xs text-gray-500">{{ $footerLine }}</p>
        </div>
    </div>
</footer>
