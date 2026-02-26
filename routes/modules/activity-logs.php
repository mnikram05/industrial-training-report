<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use App\Modules\ActivityLog\Controllers\ActivityLogController;
use App\Modules\ActivityLog\Controllers\ExportActivityLogController;

Route::middleware( ['auth'] )->group( function (): void {
    Route::get( 'activity-logs/export', ExportActivityLogController::class )
        ->name( 'activity-logs.export' );

    Route::get( 'activity-logs', [ActivityLogController::class, 'index'] )
        ->name( 'activity-logs.index' );

    Route::get( 'activity-logs/{activity}', [ActivityLogController::class, 'show'] )
        ->name( 'activity-logs.show' );
} );
