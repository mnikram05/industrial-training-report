<?php

use Illuminate\Support\Facades\Route;
use Modules\PortalAdministration\Http\Controllers\PortalAdministrationController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('portaladministrations', PortalAdministrationController::class)->names('portaladministration');
});
