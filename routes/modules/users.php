<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use App\Modules\User\Controllers\UserController;
use App\Modules\User\Controllers\ExportUserController;
use App\Modules\User\Controllers\ImportUserController;

Route::middleware( ['auth'] )->group( function (): void {
    Route::get( 'users/export', ExportUserController::class )
        ->name( 'users.export' );

    Route::post( 'users/import', ImportUserController::class )
        ->name( 'users.import' );

    Route::resource( 'users', UserController::class );
} );
