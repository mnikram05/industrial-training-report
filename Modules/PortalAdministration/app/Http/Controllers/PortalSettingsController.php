<?php

declare(strict_types=1);

namespace Modules\PortalAdministration\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Modules\PortalAdministration\Models\Menu;
use Modules\PortalAdministration\Models\Media;
use Modules\PortalAdministration\Models\PortalSetting;

class PortalSettingsController extends Controller
{
    public function edit( Request $request ): View
    {
        $page = $request->query( 'page', '' );

        if ( $page === 'cms' ) {
            $settings = PortalSetting::forPage( 'cms' );
        } elseif ( $page !== '' ) {
            $settings = PortalSetting::forPage( $page );
        } else {
            $settings = [];
        }

        $parentMenus = Menu::query()
            ->whereNull( 'parent_id' )
            ->where( 'status_id', 1 )
            ->ordered()
            ->get();

        $blocks = ( $page && ! in_array( $page, ['header-footer', 'cms'], true ) )
            ? PortalSetting::getBlocks( $page )
            : [];

        return view( 'portaladministration::portal.settings', [
            'pages'        => collect( $this->getPageOptions() )->map( fn ( $group ) => collect( $group ) ),
            'selectedPage' => $page,
            'settings'     => $settings,
            'blocks'       => $blocks,
            'mediaOptions' => $this->getMediaOptions(),
            'parentMenus'  => $parentMenus,
        ] );
    }

    public function update( Request $request ): RedirectResponse
    {
        $page = $request->input( 'page', 'home' );

        if ( $page === 'cms' ) {
            return $this->updateCmsOnly( $request );
        }

        if ( $page === 'header-footer' ) {
            return $this->updateHeaderFooter( $request );
        }

        // Block-based pages
        PortalSetting::setValue( 'blocks', $request->input( 'blocks' ), $page );
        $this->saveColors( $request, $page );

        return redirect()
            ->route( 'portal-settings.edit', ['page' => $page] )
            ->with( 'status', 'settings-updated' );
    }

    private function updateCmsOnly( Request $request ): RedirectResponse
    {
        PortalSetting::setValue( 'cms_logo_path', $request->input( 'cms_logo_path' ), 'cms' );
        PortalSetting::setValue( 'cms_footer_ms', $request->input( 'cms_footer_ms' ), 'cms' );
        PortalSetting::setValue( 'cms_footer_en', $request->input( 'cms_footer_en' ), 'cms' );
        $this->saveColors( $request, 'cms' );

        return redirect()
            ->route( 'portal-settings.edit', ['page' => 'cms'] )
            ->with( 'status', 'settings-updated' );
    }

    private function updateHeaderFooter( Request $request ): RedirectResponse
    {
        $page = 'header-footer';

        PortalSetting::setValue( 'logo_path', $request->input( 'logo_path' ), $page );
        PortalSetting::setValue( 'menu_atas_id', $request->input( 'menu_atas_id' ), $page );
        PortalSetting::setValue( 'menu_bawah_id', $request->input( 'menu_bawah_id' ), $page );

        foreach ( ['site_name', 'footer_text'] as $base ) {
            PortalSetting::setValue( $base . '_ms', $request->input( $base . '_ms' ), $page );
            PortalSetting::setValue( $base . '_en', $request->input( $base . '_en' ), $page );
        }

        $this->saveColors( $request, $page );

        return redirect()
            ->route( 'portal-settings.edit', ['page' => $page] )
            ->with( 'status', 'settings-updated' );
    }

    private function saveColors( Request $request, string $page ): void
    {
        $colors = [
            'color_header_bg', 'color_hero_bg_from', 'color_hero_bg_to', 'color_hero_glow',
            'color_accent', 'color_footer_bg', 'color_body_bg',
            'color_lang_active', 'color_card_bg', 'color_nav_bg', 'color_text',
            'dark_header_bg', 'dark_hero_bg_from', 'dark_hero_bg_to', 'dark_hero_glow',
            'dark_body_bg', 'dark_card_bg', 'dark_nav_bg',
            'dark_text', 'dark_footer_bg', 'dark_accent', 'dark_lang_active',
        ];

        foreach ( $colors as $color ) {
            if ( $request->has( $color ) ) {
                PortalSetting::setValue( $color, $request->input( $color ), $page );
            }
        }
    }

    /**
     * @return array<string, array<string, string>>
     */
    private function getPageOptions(): array
    {
        $general = [
            'header-footer' => __( 'modules/portal-administration/portal-setting.pages.header_footer' ),
        ];

        $cms = [
            'cms' => __( 'modules/portal-administration/portal-setting.pages.cms' ),
        ];

        $pages = [
            'home'                => __( 'modules/portal-administration/portal-setting.pages.home' ),
            'pengenalan-diri'     => __( 'modules/portal-administration/portal-setting.pages.pengenalan' ),
            'latar-belakang'      => __( 'modules/portal-administration/portal-setting.pages.latar_belakang' ),
            'objektif-organisasi' => __( 'modules/portal/setting.pages.objektif_organisasi' ),
            'visi-misi'           => __( 'modules/portal/setting.pages.visi_misi' ),
            'carta-organisasi'    => __( 'modules/portal/setting.pages.carta_organisasi' ),
            'fungsi-bahagian'     => __( 'modules/portal/setting.pages.fungsi_bahagian' ),
            'halatuju-organisasi' => __( 'modules/portal/setting.pages.halatuju_organisasi' ),
        ];

        $menuAtasId = PortalSetting::getValue( 'menu_atas_id', null, 'header-footer' )
            ?? PortalSetting::getValue( 'menu_atas_id' );

        if ( $menuAtasId ) {
            $children = Menu::query()
                ->where( 'parent_id', $menuAtasId )
                ->where( 'status_id', 1 )
                ->ordered()
                ->get();

            foreach ( $children as $child ) {
                $slug = Str::slug( $child->slug ?? $child->title_en ?? $child->title_my ?? '' );

                if ( $slug === 'home' ) {
                    continue;
                }

                $pages[$slug] = $child->title_my ?? $child->title_en ?? '—';
            }
        }

        return [
            __( 'modules/portal-administration/portal-setting.groups.general' ) => $general,
            __( 'modules/portal-administration/portal-setting.groups.cms' )     => $cms,
            __( 'modules/portal-administration/portal-setting.groups.pages' )   => $pages,
        ];
    }

    /**
     * @return array<string, string>
     */
    private function getMediaOptions(): array
    {
        return Media::query()
            ->latest()
            ->get()
            ->mapWithKeys( fn ( Media $media ) => [$media->path => ( $media->collection ? $media->collection . ' — ' : '' ) . $media->name] )
            ->all();
    }
}
