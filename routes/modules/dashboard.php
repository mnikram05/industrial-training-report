<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use App\Modules\Dashboard\Controllers\DashboardController;

Route::middleware( ['auth'] )->group( function (): void {
    Route::get( 'dashboard', DashboardController::class )
        ->name( 'dashboard' );
} );
