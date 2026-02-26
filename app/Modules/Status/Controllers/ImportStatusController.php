<?php

declare(strict_types=1);

namespace App\Modules\Status\Controllers;

use App\Support\Status\Status;
use Illuminate\Http\RedirectResponse;
use App\Modules\Status\Imports\StatusImport;
use App\Modules\Status\Requests\StatusImportRequest;
use App\Http\Controllers\AbstractModuleImportController;

class ImportStatusController extends AbstractModuleImportController
{
    protected const AUTHORIZATION_TARGET = Status::class;

    protected const RESOURCE_NAME = 'statuses';

    protected const IMPORT_CLASS = StatusImport::class;

    protected const LOG_NAME = 'statuses';

    protected const RESOURCE_LABEL = 'Statuses';

    protected const INDEX_ROUTE_NAME = 'statuses.index';

    public function __invoke( StatusImportRequest $request ): RedirectResponse
    {
        return $this->handleImport( $request );
    }
}
