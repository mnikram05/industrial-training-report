<?php

declare(strict_types=1);

use App\Support\Breadcrumbs\Breadcrumbs;
use App\Support\Breadcrumbs\BreadcrumbTrail;
use Modules\PortalAdministration\Models\Article;

Breadcrumbs::for( 'articles.index', function ( BreadcrumbTrail $trail ): void {
    $trail
        ->parent( 'dashboard' )
        ->push( __( 'Articles' ), route( 'articles.index' ) );
} );

Breadcrumbs::for( 'articles.create', function ( BreadcrumbTrail $trail ): void {
    $trail
        ->parent( 'articles.index' )
        ->push( __( 'Create' ) );
} );

Breadcrumbs::for( 'articles.edit', function ( BreadcrumbTrail $trail ): void {
    $trail
        ->parent( 'articles.index' )
        ->push( __( 'Edit' ) );
} );

Breadcrumbs::for( 'articles.show', function ( BreadcrumbTrail $trail, mixed $article ): void {
    $label = $article instanceof Article
        ? $article->title
        : __( 'Show' );

    $trail
        ->parent( 'articles.index' )
        ->push( $label );
} );
