<?php

declare(strict_types=1);

namespace Modules\PortalAdministration\Http\Controllers;

use Modules\PortalAdministration\Models\Article;
use Modules\PortalAdministration\Exports\ArticleExport;
use App\Http\Controllers\AbstractModuleExportController;

class ExportArticleController extends AbstractModuleExportController
{
    protected const AUTHORIZATION_TARGET = Article::class;

    protected const RESOURCE_NAME = 'articles';

    protected const EXPORT_CLASS = ArticleExport::class;

    protected const LOG_NAME = 'articles';

    protected const RESOURCE_LABEL = 'Articles';

    protected const INDEX_ROUTE_NAME = 'articles.index';
}
