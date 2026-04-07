<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use App\Modules\Role\Controllers\RoleController;
use App\Modules\Role\Controllers\ExportRoleController;
use App\Modules\Role\Controllers\ImportRoleController;

Route::middleware( ['auth'] )->group( function (): void {
    Route::get( 'roles/export', ExportRoleController::class )
        ->name( 'roles.export' );

    Route::post( 'roles/import', ImportRoleController::class )
        ->name( 'roles.import' );

    Route::get( 'roles/data', [RoleController::class, 'data'] )
        ->middleware( 'throttle:datatable-json' )
        ->name( 'roles.data' );

    Route::resource( 'roles', RoleController::class );
} );
