<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\Portal\Http\Controllers\LandingController;
use Modules\Portal\Http\Controllers\GenericPageController;

/*
|--------------------------------------------------------------------------
| Portal (public)
|--------------------------------------------------------------------------
*/
Route::prefix( 'portal' )->name( 'portal.' )->group( function (): void {
    Route::get( '/', LandingController::class )->name( 'home' );
    Route::get( '{slug}', GenericPageController::class )->name( 'page' );
} );
