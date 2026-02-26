<?php

declare(strict_types=1);

namespace App\Modules\Role\Controllers;

use Spatie\Permission\Models\Role;
use Illuminate\Http\RedirectResponse;
use App\Modules\Role\Imports\RoleImport;
use App\Modules\Role\Requests\RoleImportRequest;
use App\Http\Controllers\AbstractModuleImportController;

class ImportRoleController extends AbstractModuleImportController
{
    protected const AUTHORIZATION_TARGET = Role::class;

    protected const RESOURCE_NAME = 'roles';

    protected const IMPORT_CLASS = RoleImport::class;

    protected const LOG_NAME = 'roles';

    protected const RESOURCE_LABEL = 'Roles';

    protected const INDEX_ROUTE_NAME = 'roles.index';

    public function __invoke( RoleImportRequest $request ): RedirectResponse
    {
        return $this->handleImport( $request );
    }
}
