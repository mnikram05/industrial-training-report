<?php

declare(strict_types=1);

use Spatie\Permission\Models\Role;
use App\Support\Breadcrumbs\Breadcrumbs;
use App\Support\Breadcrumbs\BreadcrumbTrail;

Breadcrumbs::for( 'roles.index', function ( BreadcrumbTrail $trail ): void {
    $trail
        ->parent( 'dashboard' )
        ->push( __( 'Roles' ), route( 'roles.index' ) );
} );

Breadcrumbs::for( 'roles.create', function ( BreadcrumbTrail $trail ): void {
    $trail
        ->parent( 'roles.index' )
        ->push( __( 'Create' ) );
} );

Breadcrumbs::for( 'roles.show', function ( BreadcrumbTrail $trail, mixed $role ): void {
    $label = $role instanceof Role
        ? $role->name
        : __( 'Show' );

    $trail
        ->parent( 'roles.index' )
        ->push( $label );
} );

Breadcrumbs::for( 'roles.edit', function ( BreadcrumbTrail $trail ): void {
    $trail
        ->parent( 'roles.index' )
        ->push( __( 'Edit' ) );
} );
