<?php

use Illuminate\Support\Facades\Route;
use Modules\PortalAdministration\Http\Controllers\PortalAdministrationController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('portaladministrations', PortalAdministrationController::class)->names('portaladministration');
});
