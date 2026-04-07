<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use App\Modules\Status\Controllers\StatusController;
use App\Modules\Status\Controllers\ExportStatusController;
use App\Modules\Status\Controllers\ImportStatusController;

Route::middleware( ['auth'] )->group( function (): void {
    Route::get( 'statuses/export', ExportStatusController::class )
        ->name( 'statuses.export' );

    Route::post( 'statuses/import', ImportStatusController::class )
        ->name( 'statuses.import' );

    Route::get( 'statuses/data', [StatusController::class, 'data'] )
        ->middleware( 'throttle:datatable-json' )
        ->name( 'statuses.data' );

    Route::get( 'statuses/{status}/data', [StatusController::class, 'dataForModule'] )
        ->middleware( 'throttle:datatable-json' )
        ->name( 'statuses.show.data' );

    Route::resource( 'statuses', StatusController::class );
} );
