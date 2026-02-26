<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::preventLazyLoading( ! $this->app->isProduction() );
        Model::preventSilentlyDiscardingAttributes( ! $this->app->isProduction() );

        $breadcrumbsPath = base_path( 'routes/breadcrumbs/modules.php' );

        if ( is_file( $breadcrumbsPath ) ) {
            require $breadcrumbsPath;
        }
    }
}
