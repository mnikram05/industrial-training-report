<?php

declare(strict_types=1);

namespace App\Modules\ActivityLog\Controllers;

use Spatie\Activitylog\Models\Activity;
use App\Modules\ActivityLog\Exports\ActivityLogExport;
use App\Http\Controllers\AbstractModuleExportController;

class ExportActivityLogController extends AbstractModuleExportController
{
    protected const AUTHORIZATION_TARGET = Activity::class;

    protected const RESOURCE_NAME = 'activity-logs';

    protected const EXPORT_CLASS = ActivityLogExport::class;

    protected const LOG_NAME = 'activity-logs';

    protected const RESOURCE_LABEL = 'Activity Logs';

    protected const INDEX_ROUTE_NAME = 'activity-logs.index';
}
