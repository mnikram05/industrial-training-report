<?php

declare(strict_types=1);

namespace App\Modules\User\Controllers;

use App\Modules\User\Models\User;
use App\Modules\User\Exports\UserExport;
use App\Http\Controllers\AbstractModuleExportController;

class ExportUserController extends AbstractModuleExportController
{
    protected const AUTHORIZATION_TARGET = User::class;

    protected const RESOURCE_NAME = 'users';

    protected const EXPORT_CLASS = UserExport::class;

    protected const LOG_NAME = 'users';

    protected const RESOURCE_LABEL = 'Users';

    protected const INDEX_ROUTE_NAME = 'users.index';
}
