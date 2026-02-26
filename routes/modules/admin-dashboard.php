<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use App\Modules\AdminDashboard\Controllers\AdminDashboardController;

Route::middleware( ['auth'] )->group( function (): void {
    Route::get( 'admin/dashboard', AdminDashboardController::class )
        ->name( 'admin.dashboard' );
} );
