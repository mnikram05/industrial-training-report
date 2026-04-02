<?php

declare(strict_types=1);

namespace App\Providers;

use App\Modules\User\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Illuminate\View\View as BladeView;
use Illuminate\Support\ServiceProvider;
use Modules\PortalAdministration\Models\PortalSetting;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer( 'layouts.partials.menu', function ( BladeView $view ): void {
            $view->with( 'cmsOpen', request()->routeIs(
                'admin.dashboard',
                'landings.*',
                'statuses.*',
                'users.*',
                'roles.*',
                'activity-logs.*',
            ) );

            $view->with( 'portalOpen', request()->routeIs(
                'portal-administration.menus.*',
                'articles.*',
                'media.*',
                'portal-settings.*',
            ) );

            $view->with( 'referencesOpen', request()->routeIs(
                'reference.states.*',
                'reference.parliaments.*',
                'reference.duns.*',
                'reference.districts.*',
                'reference.data-references.*',
            ) );

            // Note: DUNs and Districts are accessed via States > Parliaments/Districts actions,
            // but still trigger referencesOpen for sidebar highlight.
        } );

        View::composer( 'layouts.partials.navigation', function ( BladeView $view ): void {
            $user = auth()->user();

            if ( ! $user instanceof User ) {
                return;
            }

            $locale = app()->getLocale();

            $pathForCmsBar = PortalSetting::resolvedCmsBarLogoPath() ?? '';
            $cmsPortalLogoUrl = $pathForCmsBar !== ''
                ? Storage::disk( 'public' )->url( $pathForCmsBar )
                : null;

            $cmsHeaderBrandLine = PortalSetting::getValue( 'site_name_ms', null, 'header-footer' )
                ?: PortalSetting::getValue( 'site_name_en', null, 'header-footer' )
                ?: config( 'app.name' );

            $view->with( [
                'user'                 => $user,
                'avatarFallback'       => $this->avatarFallback( $user ),
                'profileEditUrl'       => route( 'account.edit' ),
                'currentLocale'        => $locale,
                'localeLabel'          => $locale === 'ms' ? __( 'Melayu' ) : __( 'English' ),
                'isImpersonating'      => function_exists( 'is_impersonating' ) && is_impersonating(),
                'cmsPortalLogoUrl'     => $cmsPortalLogoUrl,
                'cmsHeaderBrandLine'   => is_string( $cmsHeaderBrandLine ) ? $cmsHeaderBrandLine : config( 'app.name' ),
            ] );
        } );
    }

    private function avatarFallback( User $user ): string
    {
        return collect( explode( ' ', $user->name ) )
            ->filter()
            ->map( static fn ( string $part ): string => strtoupper( substr( $part, 0, 1 ) ) )
            ->take( 2 )
            ->implode( '' );
    }
}
