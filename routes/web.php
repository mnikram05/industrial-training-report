<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::get( '/', fn () => redirect()->route( 'dashboard' ) );

require __DIR__ . '/modules/dashboard.php';
require __DIR__ . '/modules/users.php';
require __DIR__ . '/modules/roles.php';
require __DIR__ . '/modules/landings.php';
require __DIR__ . '/modules/statuses.php';
require __DIR__ . '/modules/activity-logs.php';
require __DIR__ . '/modules/exports.php';
require __DIR__ . '/modules/admin-dashboard.php';
require __DIR__ . '/search.php';
require __DIR__ . '/modules/auth.php';
require __DIR__ . '/modules/localization.php';
