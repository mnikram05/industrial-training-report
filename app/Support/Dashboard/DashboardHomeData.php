<?php

declare(strict_types=1);

namespace App\Support\Dashboard;

use App\Modules\Role\Constants\RolePermissionConstants;
use App\Modules\User\Models\User;
use Illuminate\Support\Collection;
use Modules\PortalAdministration\Models\PortalSetting;
use Spatie\Activitylog\Models\Activity;

final class DashboardHomeData
{
    /**
     * @return array{
     *     shortcuts: list<array{label: string, href: string, external: bool}>,
     *     portalChecklist: list<array{page: string, label: string, ready: bool, edit_url: string}>,
     *     portalReadyCount: int,
     *     portalTotalCount: int,
     *     recentActivities: Collection<int, Activity>
     * }
     */
    public function build(User $user): array
    {
        $portalChecklist = $this->portalChecklist();
        $ready = collect($portalChecklist)->where('ready', true)->count();

        return [
            'shortcuts' => $this->shortcuts($user),
            'portalChecklist' => $portalChecklist,
            'portalReadyCount' => $ready,
            'portalTotalCount' => count($portalChecklist),
            'recentActivities' => $this->recentActivities($user),
        ];
    }

    /**
     * @return list<array{label: string, href: string, external: bool}>
     */
    private function shortcuts(User $user): array
    {
        $items = [
            [
                'label' => __('dashboard.shortcuts.portal_public'),
                'href' => route('portal.home'),
                'external' => true,
            ],
            [
                'label' => __('dashboard.shortcuts.portal_header'),
                'href' => route('portal-settings.edit', ['page' => 'header-footer']),
                'external' => false,
            ],
            [
                'label' => __('dashboard.shortcuts.portal_home'),
                'href' => route('portal-settings.edit', ['page' => 'home']),
                'external' => false,
            ],
            [
                'label' => __('dashboard.shortcuts.menus'),
                'href' => route('portal-administration.menus.index'),
                'external' => false,
            ],
        ];

        if ($user->can(RolePermissionConstants::ARTICLES_VIEW)) {
            $items[] = [
                'label' => __('dashboard.shortcuts.articles'),
                'href' => route('articles.index'),
                'external' => false,
            ];
        }

        $items[] = [
            'label' => __('dashboard.shortcuts.media'),
            'href' => route('media.index'),
            'external' => false,
        ];

        return $items;
    }

    /**
     * @return list<array{page: string, label: string, ready: bool, edit_url: string}>
     */
    private function portalChecklist(): array
    {
        $rows = [
            [
                'page' => 'header-footer',
                'label' => __('dashboard.checklist.header_footer'),
                'ready' => $this->isHeaderFooterReady(),
            ],
            [
                'page' => 'home',
                'label' => __('dashboard.checklist.home'),
                'ready' => $this->pageHasBlocks('home'),
            ],
            [
                'page' => 'pengenalan-diri',
                'label' => __('dashboard.checklist.pengenalan_diri'),
                'ready' => $this->pageHasBlocks('pengenalan-diri'),
            ],
            [
                'page' => 'penghargaan',
                'label' => __('dashboard.checklist.penghargaan'),
                'ready' => $this->pageHasBlocks('penghargaan'),
            ],
            [
                'page' => 'ringkasan-aktiviti',
                'label' => __('dashboard.checklist.ringkasan_aktiviti'),
                'ready' => $this->pageHasBlocks('ringkasan-aktiviti'),
            ],
            [
                'page' => 'lampiran',
                'label' => __('dashboard.checklist.lampiran'),
                'ready' => $this->pageHasBlocks('lampiran'),
            ],
            [
                'page' => 'laporan-teknikal',
                'label' => __('dashboard.checklist.laporan_teknikal'),
                'ready' => $this->pageHasBlocks('laporan-teknikal'),
            ],
        ];

        return collect($rows)
            ->map(fn (array $row): array => [
                'page' => $row['page'],
                'label' => $row['label'],
                'ready' => $row['ready'],
                'edit_url' => route('portal-settings.edit', ['page' => $row['page']]),
            ])
            ->all();
    }

    private function isHeaderFooterReady(): bool
    {
        $settings = PortalSetting::forPage('header-footer');
        $menuId = $settings['menu_atas_id'] ?? null;
        $hasMenu = $menuId !== null && $menuId !== '';

        $hasBranding = filled($settings['site_name_ms'] ?? null)
            || filled($settings['site_name_en'] ?? null)
            || filled(PortalSetting::resolvedLogoPathForHeaderFooter());

        return $hasMenu && $hasBranding;
    }

    private function pageHasBlocks(string $page): bool
    {
        return count(PortalSetting::getBlocks($page)) > 0;
    }

    /**
     * @return Collection<int, Activity>
     */
    private function recentActivities(User $user): Collection
    {
        if (! $user->can(RolePermissionConstants::ACTIVITY_LOGS_VIEW)) {
            return collect();
        }

        return Activity::query()
            ->latest()
            ->with('causer')
            ->limit(8)
            ->get();
    }
}
