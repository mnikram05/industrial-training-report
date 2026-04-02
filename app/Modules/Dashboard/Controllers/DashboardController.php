<?php

declare(strict_types=1);

namespace App\Modules\Dashboard\Controllers;

use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\User\Models\User;
use App\Support\Dashboard\DashboardHomeData;

class DashboardController extends Controller
{
    /**
     * Display the dashboard page.
     */
    public function __invoke( Request $request, DashboardHomeData $dashboardHomeData ): View
    {
        /** @var User $user */
        $user = $request->user();

        return view( 'modules.dashboard.index', [
            'home' => $dashboardHomeData->build( $user ),
        ] );
    }
}
