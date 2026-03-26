<?php

declare(strict_types=1);

namespace Modules\PortalAdministration\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Modules\PortalAdministration\Models\Article;
use Modules\PortalAdministration\Imports\ArticleImport;
use App\Http\Controllers\AbstractModuleImportController;
use Modules\PortalAdministration\Http\Requests\ArticleImportRequest;

class ImportArticleController extends AbstractModuleImportController
{
    protected const AUTHORIZATION_TARGET = Article::class;

    protected const RESOURCE_NAME = 'articles';

    protected const IMPORT_CLASS = ArticleImport::class;

    protected const LOG_NAME = 'articles';

    protected const RESOURCE_LABEL = 'Articles';

    protected const INDEX_ROUTE_NAME = 'articles.index';

    public function __invoke( ArticleImportRequest $request ): RedirectResponse
    {
        return $this->handleImport( $request );
    }
}
