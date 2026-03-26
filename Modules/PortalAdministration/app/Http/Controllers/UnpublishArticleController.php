<?php

declare(strict_types=1);

namespace Modules\PortalAdministration\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Modules\PortalAdministration\Models\Article;
use Modules\PortalAdministration\Services\ArticleService;

class UnpublishArticleController extends Controller
{
    public function __construct(
        private ArticleService $articleService,
    ) {}

    public function __invoke( Request $request, Article $article ): RedirectResponse
    {
        $this->authorize( 'publish', $article );

        $this->articleService->unpublishArticle( $article, $request->user() );

        return back()->with( 'status', 'article-unpublished' );
    }
}
