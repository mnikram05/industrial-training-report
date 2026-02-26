<?php

declare(strict_types=1);

namespace App\Modules\Landing\Controllers;

use App\Modules\Landing\Models\Landing;
use App\Modules\Landing\Exports\LandingExport;
use App\Http\Controllers\AbstractModuleExportController;

class ExportLandingController extends AbstractModuleExportController
{
    protected const AUTHORIZATION_TARGET = Landing::class;

    protected const RESOURCE_NAME = 'landings';

    protected const EXPORT_CLASS = LandingExport::class;

    protected const LOG_NAME = 'landings';

    protected const RESOURCE_LABEL = 'Landings';

    protected const INDEX_ROUTE_NAME = 'landings.index';
}
