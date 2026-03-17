<?php

declare(strict_types=1);

namespace App\Modules\AdminDashboard\Controllers;

use Illuminate\View\View;
use App\Http\Controllers\Controller;
use App\Modules\AdminDashboard\Services\AdminDashboardService;

class AdminDashboardController extends Controller
{
    public function __construct(
        protected AdminDashboardService $adminDashboardService
    ) {}

    /**
     * Display the admin dashboard.
     */
    public function __invoke(): View
    {
        return view( 'modules.admin-dashboard.index', [
            'totalUsers'                 => $this->adminDashboardService->getTotalUsers(),
            'totalArticles'              => $this->adminDashboardService->getTotalArticles(),
            'publishedArticles'          => $this->adminDashboardService->getPublishedArticles(),
            'totalRoles'                 => $this->adminDashboardService->getTotalRoles(),
            'authenticationActivityData' => $this->adminDashboardService->getAuthenticationActivityByDay(),
            'userRoleDistributionData'   => $this->adminDashboardService->getUserRoleDistribution(),
            'activityByCategoryData'     => $this->adminDashboardService->getActivityByCategory(),
            'latestActivityItems'        => $this->adminDashboardService->getLatestActivityItems(),
            'state'                      => $this->adminDashboardService->getState(),
        ] );
    }
}
