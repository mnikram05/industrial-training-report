<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\Reference\Http\Controllers\DunController;
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

    Route::get( 'states/data', [StateController::class, 'data'] )
        ->middleware( 'throttle:datatable-json' )
        ->name( 'states.data' );

    // Standard resource routes
    Route::resource( 'states', StateController::class );

    // Restore soft-deleted parliament
    Route::patch( 'parliaments/{parliament}/restore', [ParliamentController::class, 'restore'] )
        ->name( 'parliaments.restore' );

    // Permanently delete parliament
    Route::delete( 'parliaments/{parliament}/force-delete', [ParliamentController::class, 'forceDelete'] )
        ->name( 'parliaments.force-delete' );

    // Toggle status parliament
    Route::patch( 'parliaments/{parliament}/toggle-status', [ParliamentController::class, 'toggleStatus'] )
        ->name( 'parliaments.toggle-status' );

    Route::get( 'parliaments/data', [ParliamentController::class, 'data'] )
        ->middleware( 'throttle:datatable-json' )
        ->name( 'parliaments.data' );

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

    // Toggle status DUN
    Route::patch( 'duns/{dun}/toggle-status', [DunController::class, 'toggleStatus'] )
        ->name( 'duns.toggle-status' );

    Route::get( 'duns/data', [DunController::class, 'data'] )
        ->middleware( 'throttle:datatable-json' )
        ->name( 'duns.data' );

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

    // Toggle status district
    Route::patch( 'districts/{district}/toggle-status', [DistrictController::class, 'toggleStatus'] )
        ->name( 'districts.toggle-status' );

    Route::get( 'districts/data', [DistrictController::class, 'data'] )
        ->middleware( 'throttle:datatable-json' )
        ->name( 'districts.data' );

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

    // Toggle status
    Route::patch( 'data-references/{data_reference}/toggle-status', [DataReferenceController::class, 'toggleStatus'] )
        ->name( 'data-references.toggle-status' );

    Route::get( 'data-references/{data_reference}/children/data', [DataReferenceController::class, 'childrenData'] )
        ->middleware( 'throttle:datatable-json' )
        ->name( 'data-references.children.data' );

    // Children listing
    Route::get( 'data-references/{data_reference}/children', [DataReferenceController::class, 'children'] )
        ->name( 'data-references.children' );

    // Create child
    Route::get( 'data-references/{data_reference}/children/create', [DataReferenceController::class, 'createChild'] )
        ->name( 'data-references.children.create' );

    // Store child
    Route::post( 'data-references/{data_reference}/children', [DataReferenceController::class, 'storeChild'] )
        ->name( 'data-references.children.store' );

    // Toggle child status
    Route::patch( 'data-references/{data_reference}/children/{child}/toggle-status', [DataReferenceController::class, 'toggleChildStatus'] )
        ->name( 'data-references.children.toggle-status' );

    // Update child sort order
    Route::patch( 'data-references/{data_reference}/children/{child}/update-sort', [DataReferenceController::class, 'updateChildSort'] )
        ->name( 'data-references.children.update-sort' );

    Route::get( 'data-references/data', [DataReferenceController::class, 'data'] )
        ->middleware( 'throttle:datatable-json' )
        ->name( 'data-references.data' );

    // Standard resource routes
    Route::resource( 'data-references', DataReferenceController::class );

    // Update sort order data reference
    Route::patch( 'data-references/{data_reference}/update-sort', [DataReferenceController::class, 'updateSort'] )
        ->name( 'data-references.update-sort' );
} );
