<?php

declare(strict_types=1);

use App\Support\Breadcrumbs\Breadcrumbs;
use App\Support\Breadcrumbs\BreadcrumbTrail;

Breadcrumbs::for( 'account.edit', function ( BreadcrumbTrail $trail ): void {
    $trail
        ->parent( 'dashboard' )
        ->push( __( 'Account' ) );
} );
