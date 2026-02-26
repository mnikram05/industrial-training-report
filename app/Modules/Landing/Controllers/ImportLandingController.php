<?php

declare(strict_types=1);

namespace App\Modules\Landing\Controllers;

use Illuminate\Http\RedirectResponse;
use App\Modules\Landing\Models\Landing;
use App\Modules\Landing\Imports\LandingImport;
use App\Modules\Landing\Requests\LandingImportRequest;
use App\Http\Controllers\AbstractModuleImportController;

class ImportLandingController extends AbstractModuleImportController
{
    protected const AUTHORIZATION_TARGET = Landing::class;

    protected const RESOURCE_NAME = 'landings';

    protected const IMPORT_CLASS = LandingImport::class;

    protected const LOG_NAME = 'landings';

    protected const RESOURCE_LABEL = 'Landings';

    protected const INDEX_ROUTE_NAME = 'landings.index';

    public function __invoke( LandingImportRequest $request ): RedirectResponse
    {
        return $this->handleImport( $request );
    }
}
