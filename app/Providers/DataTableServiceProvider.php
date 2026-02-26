<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class DataTableServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void {}

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::share( 'dataTableDefaultOptions', [
            'processing'   => true,
            'serverSide'   => true,
            'lengthChange' => false,
            'pagingType'   => 'simple_numbers',
            'scrollX'      => false,
        ] );
    }
}
