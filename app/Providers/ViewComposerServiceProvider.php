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

            $view->with( [
                'user'                 => $user,
                'avatarFallback'       => $this->avatarFallback( $user ),
                'profileEditUrl'       => route( 'account.edit' ),
                'currentLocale'        => $locale,
                'localeLabel'          => $locale === 'ms' ? __( 'ui.locale_ms' ) : __( 'ui.english' ),
                'isImpersonating'      => function_exists( 'is_impersonating' ) && is_impersonating(),
                'cmsPortalLogoUrl'     => $cmsPortalLogoUrl,
                'cmsHeaderBrandLine'   => PortalSetting::headerSiteDisplayName( $locale ),
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
