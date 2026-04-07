<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::preventLazyLoading( ! $this->app->isProduction() );
        Model::preventSilentlyDiscardingAttributes( ! $this->app->isProduction() );

        $this->configureRateLimiting();

        $breadcrumbsPath = base_path( 'routes/breadcrumbs/modules.php' );

        if ( is_file( $breadcrumbsPath ) ) {
            require $breadcrumbsPath;
        }
    }

    protected function configureRateLimiting(): void
    {
        RateLimiter::for( 'datatable-json', function ( Request $request ): Limit {
            return Limit::perMinute( 120 )->by( $request->user()?->getAuthIdentifier() ?: $request->ip() );
        } );
    }
}
