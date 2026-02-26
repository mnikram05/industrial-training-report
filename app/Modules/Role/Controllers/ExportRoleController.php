<?php

declare(strict_types=1);

namespace App\Modules\Role\Controllers;

use Spatie\Permission\Models\Role;
use App\Modules\Role\Exports\RoleExport;
use App\Http\Controllers\AbstractModuleExportController;

class ExportRoleController extends AbstractModuleExportController
{
    protected const AUTHORIZATION_TARGET = Role::class;

    protected const RESOURCE_NAME = 'roles';

    protected const EXPORT_CLASS = RoleExport::class;

    protected const LOG_NAME = 'roles';

    protected const RESOURCE_LABEL = 'Roles';

    protected const INDEX_ROUTE_NAME = 'roles.index';
}
