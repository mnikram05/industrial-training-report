<?php

declare(strict_types=1);

use App\Support\Breadcrumbs\Breadcrumbs;
use App\Support\Breadcrumbs\BreadcrumbTrail;

Breadcrumbs::for( 'dashboard', function ( BreadcrumbTrail $trail ): void {
    $trail->push( __( 'ui.dashboard' ), route( 'dashboard' ) );
} );
