<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\Reference\Http\Controllers\ReferenceController;

Route::middleware( ['auth:sanctum'] )->prefix( 'v1' )->group( function () {
    Route::apiResource( 'references', ReferenceController::class )->names( 'reference' );
} );
