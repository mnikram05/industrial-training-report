<?php

declare(strict_types=1);

use Spatie\Activitylog\Models\Activity;
use App\Support\Breadcrumbs\Breadcrumbs;
use App\Support\Breadcrumbs\BreadcrumbTrail;

Breadcrumbs::for( 'activity-logs.index', function ( BreadcrumbTrail $trail ): void {
    $trail
        ->parent( 'dashboard' )
        ->push( __( 'Activity Logs' ), route( 'activity-logs.index' ) );
} );

Breadcrumbs::for( 'activity-logs.show', function ( BreadcrumbTrail $trail, mixed $activity ): void {
    $activityKey = $activity instanceof Activity ? $activity->getKey() : null;
    $label       = is_scalar( $activityKey )
        ? '#' . (string) $activityKey
        : __( 'Show' );

    $trail
        ->parent( 'activity-logs.index' )
        ->push( $label );
} );
