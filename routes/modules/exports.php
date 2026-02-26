<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExportStatusController;
use App\Http\Controllers\ExportDownloadController;

Route::middleware( ['auth'] )
    ->prefix( 'exports' )
    ->name( 'exports.' )
    ->group( function (): void {
        Route::get( 'download', ExportDownloadController::class )
            ->name( 'download' );

        Route::get( 'status/{transfer}', ExportStatusController::class )
            ->name( 'status' );
    } );
