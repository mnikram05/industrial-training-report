<?php

declare(strict_types=1);

use App\Support\Breadcrumbs\Breadcrumbs;
use App\Support\Breadcrumbs\BreadcrumbTrail;

Breadcrumbs::for( 'landings.index', function ( BreadcrumbTrail $trail ): void {
    $trail
        ->parent( 'dashboard' )
        ->push( __( 'ui.landings' ), route( 'landings.index' ) );
} );

Breadcrumbs::for( 'landings.create', function ( BreadcrumbTrail $trail ): void {
    $trail
        ->parent( 'landings.index' )
        ->push( __( 'ui.create' ) );
} );

Breadcrumbs::for( 'landings.edit', function ( BreadcrumbTrail $trail ): void {
    $trail
        ->parent( 'landings.index' )
        ->push( __( 'ui.edit' ) );
} );
