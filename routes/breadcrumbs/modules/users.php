<?php

declare(strict_types=1);

use App\Modules\User\Models\User;
use App\Support\Breadcrumbs\Breadcrumbs;
use App\Support\Breadcrumbs\BreadcrumbTrail;

Breadcrumbs::for( 'users.index', function ( BreadcrumbTrail $trail ): void {
    $trail
        ->parent( 'dashboard' )
        ->push( __( 'ui.users' ), route( 'users.index' ) );
} );

Breadcrumbs::for( 'users.create', function ( BreadcrumbTrail $trail ): void {
    $trail
        ->parent( 'users.index' )
        ->push( __( 'ui.create' ) );
} );

Breadcrumbs::for( 'users.show', function ( BreadcrumbTrail $trail, mixed $user ): void {
    $label = $user instanceof User
        ? $user->name
        : __( 'ui.show' );

    $trail
        ->parent( 'users.index' )
        ->push( $label );
} );

Breadcrumbs::for( 'users.edit', function ( BreadcrumbTrail $trail ): void {
    $trail
        ->parent( 'users.index' )
        ->push( __( 'ui.edit' ) );
} );
