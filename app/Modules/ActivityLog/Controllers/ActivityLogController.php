<?php

declare(strict_types=1);

namespace App\Modules\ActivityLog\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Spatie\Activitylog\Models\Activity;
use App\Support\Export\LatestCompletedExportPathResolver;
use App\Modules\ActivityLog\DataTables\ActivityLogDataTable;

class ActivityLogController extends Controller
{
    public function __construct(
        protected ActivityLogDataTable $activityLogDataTable,
        private LatestCompletedExportPathResolver $latestCompletedExportPathResolver,
    ) {}

    /**
     * Display a listing of activity logs.
     */
    public function index( Request $request ): View
    {
        $this->authorize( 'viewAny', Activity::class );

        $latestExportPath = $this->latestCompletedExportPathResolver->resolve( 'activity-logs', $request->user() );

        return view( 'modules.activity-logs.index', [
            'dataTable'        => $this->activityLogDataTable,
            'latestExportPath' => $latestExportPath,
        ] );
    }

    public function data( Request $request ): JsonResponse
    {
        $this->authorize( 'viewAny', Activity::class );

        return $this->activityLogDataTable->ajax();
    }

    /**
     * Display the specified activity log.
     */
    public function show( Activity $activity ): View
    {
        $this->authorize( 'view', $activity );

        return view( 'modules.activity-logs.show', [
            'activity' => $activity->load( 'causer' ),
        ] );
    }
}
