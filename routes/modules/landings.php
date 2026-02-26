<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use App\Modules\Landing\Controllers\LandingController;
use App\Modules\Landing\Controllers\ExportLandingController;
use App\Modules\Landing\Controllers\ImportLandingController;

Route::middleware( ['auth'] )->group( function (): void {
    Route::get( 'landings/export', ExportLandingController::class )
        ->name( 'landings.export' );

    Route::post( 'landings/import', ImportLandingController::class )
        ->name( 'landings.import' );

    Route::resource( 'landings', LandingController::class )
        ->except( ['show'] );
} );
