<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\Reference\Http\Controllers\DunController;
use Modules\Reference\Http\Controllers\MenuController;
use Modules\Reference\Http\Controllers\StateController;
use Modules\Reference\Http\Controllers\DistrictController;
use Modules\Reference\Http\Controllers\ParliamentController;
use Modules\Reference\Http\Controllers\DataReferenceController;

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

    Route::patch( 'parliaments/{parliament}/update-sort', [ParliamentController::class, 'updateSort'] )
        ->name( 'parliaments.update-sort' );

    // Restore soft-deleted DUN
    Route::patch( 'duns/{dun}/restore', [DunController::class, 'restore'] )
        ->name( 'duns.restore' );

    // Permanently delete DUN
    Route::delete( 'duns/{dun}/force-delete', [DunController::class, 'forceDelete'] )
        ->name( 'duns.force-delete' );

    // Standard resource routes
    Route::resource( 'duns', DunController::class );

    // Update sort order DUN
    Route::patch( 'duns/{dun}/update-sort', [DunController::class, 'updateSort'] )
        ->name( 'duns.update-sort' );

    // Restore soft-deleted district
    Route::patch( 'districts/{district}/restore', [DistrictController::class, 'restore'] )
        ->name( 'districts.restore' );

    // Permanently delete district
    Route::delete( 'districts/{district}/force-delete', [DistrictController::class, 'forceDelete'] )
        ->name( 'districts.force-delete' );

    // Standard resource routes
    Route::resource( 'districts', DistrictController::class );

    // Update sort order district
    Route::patch( 'districts/{district}/update-sort', [DistrictController::class, 'updateSort'] )
        ->name( 'districts.update-sort' );

    // Restore soft-deleted data reference
    Route::patch( 'data-references/{data_reference}/restore', [DataReferenceController::class, 'restore'] )
        ->name( 'data-references.restore' );

    // Permanently delete data reference
    Route::delete( 'data-references/{data_reference}/force-delete', [DataReferenceController::class, 'forceDelete'] )
        ->name( 'data-references.force-delete' );

    // Standard resource routes
    Route::resource( 'data-references', DataReferenceController::class );

    // Update sort order data reference
    Route::patch( 'data-references/{data_reference}/update-sort', [DataReferenceController::class, 'updateSort'] )
        ->name( 'data-references.update-sort' );

    // Restore soft-deleted menu
    Route::patch( 'menus/{menu}/restore', [MenuController::class, 'restore'] )
        ->name( 'menus.restore' );

    // Permanently delete menu
    Route::delete( 'menus/{menu}/force-delete', [MenuController::class, 'forceDelete'] )
        ->name( 'menus.force-delete' );

    // Standard resource routes
    Route::resource( 'menus', MenuController::class );

    // Update sort order menu
    Route::patch( 'menus/{menu}/update-sort', [MenuController::class, 'updateSort'] )
        ->name( 'menus.update-sort' );
} );
