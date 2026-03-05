<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\Reference\Http\Controllers\DunController;
use Modules\Reference\Http\Controllers\StateController;
use Modules\Reference\Http\Controllers\DistrictController;
use Modules\Reference\Http\Controllers\ParliamentController;

Route::middleware( ['web', 'auth'] )->prefix( 'reference' )->name( 'reference.' )->group( function () {
    // Restore soft-deleted state
    Route::patch( 'states/{state}/restore', [StateController::class, 'restore'] )
        ->name( 'states.restore' );

    // Permanently delete
    Route::delete( 'states/{state}/force-delete', [StateController::class, 'forceDelete'] )
        ->name( 'states.force-delete' );

    // Toggle status
    Route::patch( 'states/{state}/toggle-status', [StateController::class, 'toggleStatus'] )
        ->name( 'states.toggle-status' );

    // Update sort order
    Route::patch( 'states/{state}/update-sort', [StateController::class, 'updateSort'] )
        ->name( 'states.update-sort' );

    // Standard resource routes
    Route::resource( 'states', StateController::class );

    // Restore soft-deleted parliament
    Route::patch( 'parliaments/{parliament}/restore', [ParliamentController::class, 'restore'] )
        ->name( 'parliaments.restore' );

    // Permanently delete parliament
    Route::delete( 'parliaments/{parliament}/force-delete', [ParliamentController::class, 'forceDelete'] )
        ->name( 'parliaments.force-delete' );

    // Standard resource routes
    Route::resource( 'parliaments', ParliamentController::class );

    // Restore soft-deleted DUN
    Route::patch( 'duns/{dun}/restore', [DunController::class, 'restore'] )
        ->name( 'duns.restore' );

    // Permanently delete DUN
    Route::delete( 'duns/{dun}/force-delete', [DunController::class, 'forceDelete'] )
        ->name( 'duns.force-delete' );

    // Standard resource routes
    Route::resource( 'duns', DunController::class );

    // Restore soft-deleted district
    Route::patch( 'districts/{district}/restore', [DistrictController::class, 'restore'] )
        ->name( 'districts.restore' );

    // Permanently delete district
    Route::delete( 'districts/{district}/force-delete', [DistrictController::class, 'forceDelete'] )
        ->name( 'districts.force-delete' );

    // Standard resource routes
    Route::resource( 'districts', DistrictController::class );
} );
