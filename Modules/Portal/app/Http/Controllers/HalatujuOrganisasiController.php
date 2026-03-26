<?php

declare(strict_types=1);

namespace Modules\Portal\Http\Controllers;

use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Modules\PortalAdministration\Models\Menu;
use Modules\PortalAdministration\Models\PortalSetting;

class HalatujuOrganisasiController extends Controller
{
    public function __invoke(): View
    {
        $settings       = PortalSetting::forPage( 'halatuju-organisasi' );
        $homeSettings   = PortalSetting::forPage( 'home' );
        $globalSettings = PortalSetting::forPage( 'header-footer' );

        $menuAtasId  = $globalSettings['menu_atas_id'] ?? $homeSettings['menu_atas_id'] ?? null;
        $menuBawahId = $globalSettings['menu_bawah_id'] ?? $homeSettings['menu_bawah_id'] ?? null;

        $menuAtas = $menuAtasId
            ? Menu::query()
                ->where( 'parent_id', $menuAtasId )
                ->where( 'status_id', 1 )
                ->with( ['children' => fn ( $q ) => $q->where( 'status_id', 1 )] )
                ->ordered()
                ->get()
            : collect();

        $menuBawah = $menuBawahId
            ? Menu::query()
                ->where( 'parent_id', $menuBawahId )
                ->where( 'status_id', 1 )
                ->ordered()
                ->get()
            : collect();

        $l = app()->getLocale();

        return view( 'portal::halatuju-organisasi', [
            'menuAtas'  => $menuAtas,
            'menuBawah' => $menuBawah,
            's'         => $settings,
            'siteTitle' => $globalSettings['site_name_' . $l] ?? $homeSettings['site_name_' . $l] ?? config( 'app.name' ),
        ] );
    }
}
