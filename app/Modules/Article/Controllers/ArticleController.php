<?php

declare(strict_types=1);

namespace App\Modules\Article\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Modules\User\Models\User;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Modules\Article\Models\Article;
use App\Modules\Article\Dtos\ArticleDto;
use App\Modules\Article\Enums\ArticleStatusEnum;
use App\Modules\Article\Requests\ArticleRequest;
use App\Modules\Article\Services\ArticleService;
use App\Modules\Article\DataTables\ArticleDataTable;
use App\Support\Export\LatestCompletedExportPathResolver;

class ArticleController extends Controller
{
    public function __construct(
        protected ArticleService $articleService,
        protected ArticleDataTable $articleDataTable,
        private LatestCompletedExportPathResolver $latestCompletedExportPathResolver,
    ) {
        $this->authorizeResource( Article::class, 'article', ['except' => ['show']] );
    }

    /**
     * Display a listing of articles.
     */
    public function index( Request $request ): JsonResponse|View
    {
        if ( $request->ajax() ) {
            return $this->articleDataTable->ajax();
        }

        $latestExportPath = $this->latestCompletedExportPathResolver->resolve( 'articles', $request->user() );

        return view( 'modules.articles.index', [
            'dataTable'        => $this->articleDataTable,
            'latestExportPath' => $latestExportPath,
        ] );
    }

    /**
     * Show the form for creating a new article.
     */
    public function create(): View
    {
        return view( 'modules.articles.create', [
            'articleStatusOptions' => ArticleStatusEnum::options(),
        ] );
    }

    /**
     * Store a newly created article.
     */
    public function store( ArticleRequest $request ): RedirectResponse
    {
        $user = $request->user();

        if ( ! $user instanceof User ) {
            abort( 403 );
        }

        $article = $this->articleService->createArticle(
            $user,
            ArticleDto::fromArray( $request->validated() ),
        );

        return redirect()
            ->route( 'articles.edit', $article )
            ->with( 'status', 'article-created' );
    }

    /**
     * Display a public article page.
     */
    public function show( Article $article ): View
    {
        abort_unless( $article->isPublished(), 404 );

        return view( 'portal.article', [
            'article' => $article->load( 'user' ),
        ] );
    }

    /**
     * Show the form for editing an article.
     */
    public function edit( Article $article ): View
    {
        return view( 'modules.articles.edit', [
            'article'              => $article,
            'articleStatusOptions' => ArticleStatusEnum::options(),
        ] );
    }

    /**
     * Update the specified article.
     */
    public function update( ArticleRequest $request, Article $article ): RedirectResponse
    {
        $this->articleService->updateArticle(
            $article,
            ArticleDto::fromArray( $request->validated() ),
            $request->user(),
        );

        return redirect()
            ->route( 'articles.edit', $article )
            ->with( 'status', 'article-updated' );
    }

    /**
     * Remove the specified article.
     */
    public function destroy( Request $request, Article $article ): RedirectResponse
    {
        $this->articleService->deleteArticle( $article, $request->user() );

        return redirect()
            ->route( 'articles.index' )
            ->with( 'status', 'article-deleted' );
    }
}
