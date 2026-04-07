<?php

declare(strict_types=1);

namespace Modules\PortalAdministration\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Modules\User\Models\User;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Modules\Reference\Models\DataReference;
use Modules\PortalAdministration\Models\Menu;
use Modules\PortalAdministration\Models\Article;
use Modules\PortalAdministration\Dtos\ArticleDto;
use App\Support\Export\LatestCompletedExportPathResolver;
use Modules\PortalAdministration\Enums\ArticleStatusEnum;
use Modules\PortalAdministration\Services\ArticleService;
use Modules\PortalAdministration\DataTables\ArticleDataTable;
use Modules\PortalAdministration\Http\Requests\ArticleRequest;

class ArticleController extends Controller
{
    public function __construct(
        protected ArticleService $articleService,
        protected ArticleDataTable $articleDataTable,
        private LatestCompletedExportPathResolver $latestCompletedExportPathResolver,
    ) {
        $this->authorizeResource( Article::class, 'article', ['except' => ['show']] );
    }

    public function index( Request $request ): View
    {
        $latestExportPath = $this->latestCompletedExportPathResolver->resolve( 'articles', $request->user() );

        return view( 'portaladministration::articles.index', [
            'dataTable'        => $this->articleDataTable,
            'latestExportPath' => $latestExportPath,
        ] );
    }

    public function data( Request $request ): JsonResponse
    {
        $this->authorize( 'viewAny', Article::class );

        return $this->articleDataTable->ajax();
    }

    public function create(): View
    {
        return view( 'portaladministration::articles.create', [
            'articleStatusOptions'  => ArticleStatusEnum::options(),
            'menuTypeOptions'       => $this->getMenuTypeOptions(),
            'documentTypeOptions'   => $this->getDocumentTypeOptions(),
            'documentTypeKontentId' => $this->getDocumentTypeIdByLabel( 'Kontent' ),
            'documentTypeDokumenId' => $this->getDocumentTypeIdByLabel( 'Dokumen' ),
        ] );
    }

    public function store( ArticleRequest $request ): RedirectResponse
    {
        $user = $request->user();

        if ( ! $user instanceof User ) {
            abort( 403 );
        }

        $data = $request->validated();

        if ( $request->hasFile( 'file' ) ) {
            $data['file_path'] = $request->file( 'file' )->store( 'articles/documents', 'public' );
        }

        $article = $this->articleService->createArticle(
            $user,
            ArticleDto::fromArray( $data ),
        );

        return redirect()
            ->route( 'articles.edit', $article )
            ->with( 'status', 'article-created' );
    }

    public function show( Article $article ): View
    {
        abort_unless( $article->isPublished(), 404 );

        return view( 'portaladministration::portal.article', [
            'article' => $article->load( 'user' ),
        ] );
    }

    public function edit( Article $article ): View
    {
        $menuOptions = [];

        if ( $article->menu_type_id ) {
            $menuOptions = Menu::query()
                ->where( 'parent_id', $article->menu_type_id )
                ->where( 'status_id', 1 )
                ->ordered()
                ->get()
                ->mapWithKeys( fn ( Menu $m ) => [$m->id => $m->title_ms ?? $m->title_en ?? '—'] )
                ->all();
        }

        return view( 'portaladministration::articles.edit', [
            'article'               => $article,
            'articleStatusOptions'  => ArticleStatusEnum::options(),
            'menuTypeOptions'       => $this->getMenuTypeOptions(),
            'menuOptions'           => $menuOptions,
            'documentTypeOptions'   => $this->getDocumentTypeOptions(),
            'documentTypeKontentId' => $this->getDocumentTypeIdByLabel( 'Kontent' ),
            'documentTypeDokumenId' => $this->getDocumentTypeIdByLabel( 'Dokumen' ),
        ] );
    }

    public function update( ArticleRequest $request, Article $article ): RedirectResponse
    {
        $data = $request->validated();

        if ( $request->hasFile( 'file' ) ) {
            $data['file_path'] = $request->file( 'file' )->store( 'articles/documents', 'public' );
        }

        $this->articleService->updateArticle(
            $article,
            ArticleDto::fromArray( $data ),
            $request->user(),
        );

        return redirect()
            ->route( 'articles.edit', $article )
            ->with( 'status', 'article-updated' );
    }

    public function destroy( Request $request, Article $article ): RedirectResponse
    {
        $this->articleService->deleteArticle( $article, $request->user() );

        return redirect()
            ->route( 'articles.index' )
            ->with( 'status', 'article-deleted' );
    }

    /**
     * @return array<int, string>
     */
    private function getMenuTypeOptions(): array
    {
        return Menu::query()
            ->whereNull( 'parent_id' )
            ->where( 'status_id', 1 )
            ->ordered()
            ->get()
            ->mapWithKeys( fn ( Menu $m ) => [$m->id => $m->title_ms ?? $m->title_en ?? '—'] )
            ->all();
    }

    private function getDocumentTypeIdByLabel( string $label ): string
    {
        $parent = DataReference::query()
            ->whereNull( 'parent_id' )
            ->where( 'label_ms', 'Jenis Dokumen' )
            ->first();

        if ( ! $parent ) {
            return '';
        }

        $ref = DataReference::query()
            ->where( 'parent_id', $parent->id )
            ->where( 'label_ms', $label )
            ->first();

        return $ref ? (string) $ref->id : '';
    }

    /**
     * @return array<int, string>
     */
    private function getDocumentTypeOptions(): array
    {
        $parent = DataReference::query()
            ->whereNull( 'parent_id' )
            ->where( 'label_ms', 'Jenis Dokumen' )
            ->first();

        if ( ! $parent ) {
            return [];
        }

        return DataReference::query()
            ->where( 'parent_id', $parent->id )
            ->where( 'status', 1 )
            ->ordered()
            ->get()
            ->mapWithKeys( fn ( DataReference $ref ) => [$ref->id => $ref->label_ms ?? $ref->label_en ?? '—'] )
            ->all();
    }
}
