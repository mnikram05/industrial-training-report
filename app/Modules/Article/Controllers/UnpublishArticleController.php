<?php

declare(strict_types=1);

namespace App\Modules\Article\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Modules\Article\Models\Article;
use App\Modules\Article\Services\ArticleService;

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
