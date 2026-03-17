<?php

declare(strict_types=1);

namespace App\Providers;

use App\Modules\User\Models\User;
use Illuminate\Support\Facades\View;
use Illuminate\View\View as BladeView;
use Illuminate\Support\ServiceProvider;

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
                'articles.*',
                'landings.*',
                'statuses.*',
                'users.*',
                'roles.*',
                'activity-logs.*',
                'reference.menus.*',
            ) );

            $view->with( 'referencesOpen', request()->routeIs(
                'reference.states.*',
                'reference.parliaments.*',
                'reference.duns.*',
                'reference.districts.*',
                'reference.data-references.*',
            ) );
        } );

        View::composer( 'layouts.partials.navigation', function ( BladeView $view ): void {
            $user = auth()->user();

            if ( ! $user instanceof User ) {
                return;
            }

            $locale = app()->getLocale();

            $view->with( [
                'user'            => $user,
                'avatarFallback'  => $this->avatarFallback( $user ),
                'profileEditUrl'  => route( 'account.edit' ),
                'currentLocale'   => $locale,
                'localeLabel'     => $locale === 'ms' ? __( 'Melayu' ) : __( 'English' ),
                'isImpersonating' => function_exists( 'is_impersonating' ) && is_impersonating(),
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
