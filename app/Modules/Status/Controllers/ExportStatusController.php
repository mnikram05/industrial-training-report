<?php

declare(strict_types=1);

namespace App\Modules\Status\Controllers;

use App\Support\Status\Status;
use App\Modules\Status\Exports\StatusExport;
use App\Http\Controllers\AbstractModuleExportController;

class ExportStatusController extends AbstractModuleExportController
{
    protected const AUTHORIZATION_TARGET = Status::class;

    protected const RESOURCE_NAME = 'statuses';

    protected const EXPORT_CLASS = StatusExport::class;

    protected const LOG_NAME = 'statuses';

    protected const RESOURCE_LABEL = 'Statuses';

    protected const INDEX_ROUTE_NAME = 'statuses.index';
}
