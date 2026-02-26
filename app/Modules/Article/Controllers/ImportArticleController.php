<?php

declare(strict_types=1);

namespace App\Modules\Article\Controllers;

use Illuminate\Http\RedirectResponse;
use App\Modules\Article\Models\Article;
use App\Modules\Article\Imports\ArticleImport;
use App\Modules\Article\Requests\ArticleImportRequest;
use App\Http\Controllers\AbstractModuleImportController;

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
