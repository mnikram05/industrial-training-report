<?php

declare(strict_types=1);

namespace App\Modules\Dashboard\Controllers;

use Illuminate\View\View;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    /**
     * Display the dashboard page.
     */
    public function __invoke(): View
    {
        return view( 'modules.dashboard.index' );
    }
}
