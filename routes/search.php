<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GlobalSearchController;

Route::middleware( ['auth'] )->group( function (): void {
    Route::get( 'search/global', GlobalSearchController::class )
        ->name( 'search.global' );
} );
