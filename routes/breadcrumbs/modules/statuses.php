<?php

declare(strict_types=1);

use App\Support\Status\Status;
use App\Support\Breadcrumbs\Breadcrumbs;
use App\Support\Breadcrumbs\BreadcrumbTrail;

Breadcrumbs::for( 'statuses.index', function ( BreadcrumbTrail $trail ): void {
    $trail
        ->parent( 'dashboard' )
        ->push( __( 'Statuses' ), route( 'statuses.index' ) );
} );

Breadcrumbs::for( 'statuses.create', function ( BreadcrumbTrail $trail ): void {
    $trail
        ->parent( 'statuses.index' )
        ->push( __( 'Create' ) );
} );

Breadcrumbs::for( 'statuses.show', function ( BreadcrumbTrail $trail, mixed $status ): void {
    $label = $status instanceof Status
        ? sprintf( '%s (%s)', $status->label(), $status->key )
        : __( 'Show' );

    $trail
        ->parent( 'statuses.index' )
        ->push( $label );
} );

Breadcrumbs::for( 'statuses.edit', function ( BreadcrumbTrail $trail ): void {
    $trail
        ->parent( 'statuses.index' )
        ->push( __( 'Edit' ) );
} );
