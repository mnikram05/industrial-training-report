<?php

declare(strict_types=1);

namespace App\Modules\User\Controllers;

use App\Modules\User\Models\User;
use Illuminate\Http\RedirectResponse;
use App\Modules\User\Imports\UserImport;
use App\Modules\User\Requests\UserImportRequest;
use App\Http\Controllers\AbstractModuleImportController;

class ImportUserController extends AbstractModuleImportController
{
    protected const AUTHORIZATION_TARGET = User::class;

    protected const RESOURCE_NAME = 'users';

    protected const IMPORT_CLASS = UserImport::class;

    protected const LOG_NAME = 'users';

    protected const RESOURCE_LABEL = 'Users';

    protected const INDEX_ROUTE_NAME = 'users.index';

    public function __invoke( UserImportRequest $request ): RedirectResponse
    {
        return $this->handleImport( $request );
    }
}
