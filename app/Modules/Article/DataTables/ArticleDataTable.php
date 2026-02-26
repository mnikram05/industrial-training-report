<?php

declare(strict_types=1);

namespace App\Modules\Article\DataTables;

use Illuminate\Http\JsonResponse;
use App\Modules\Article\Models\Article;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Database\Eloquent\Builder;
use App\Support\DataTable\BaseModuleDataTable;

class ArticleDataTable extends BaseModuleDataTable
{
    /**
     * @return Builder<Article>
     */
    public function query(): Builder
    {
        return Article::query()
            ->select( ['id', 'user_id', 'title', 'slug', 'status_id', 'updated_at', 'published_at'] )
            ->with( 'user:id,name' );
    }

    public function ajax(): JsonResponse
    {
        return DataTables::eloquent( $this->query() )
            ->addIndexColumn()
            ->addColumn( 'author', static function ( Article $article ): string {
                $authorName = data_get( $article, 'user.name' );

                return is_string( $authorName ) && $authorName !== ''
                    ? $authorName
                    : '—';
            } )
            ->editColumn( 'status', static function ( Article $article ): string {
                return view( 'modules.articles.partials.datatables_status', [
                    'article'     => $article,
                    'statusLabel' => $article->status->label(),
                ] )->render();
            } )
            ->editColumn( 'updated_at', static fn ( Article $article ): string => $article->updated_at?->format( 'M j, Y' ) ?? '—' )
            ->addColumn( 'action', static fn ( Article $article ): string => view( 'modules.articles.partials.datatables_actions', [
                'article'          => $article,
                'canViewPublished' => $article->isPublished(),
            ] )->render() )
            ->filterColumn( 'author', static function ( Builder $query, string $keyword ): void {
                $query->whereHas( 'user', static function ( Builder $userQuery ) use ( $keyword ): void {
                    $userQuery->where( 'name', 'like', '%' . $keyword . '%' );
                } );
            } )
            ->rawColumns( ['status', 'action'] )
            ->toJson();
    }

    protected function tableId(): string
    {
        return 'articles-table';
    }

    protected function ajaxRouteName(): string
    {
        return 'articles.index';
    }

    /**
     * @return list<array{label: string, class?: string}>
     */
    protected function headings(): array
    {
        return [
            ['label' => __( 'No.' ), 'class' => 'px-4 py-3 text-left font-medium w-14'],
            ['label' => __( 'Title' ), 'class' => 'px-4 py-3 text-left font-medium'],
            ['label' => __( 'Status' ), 'class' => 'px-4 py-3 text-left font-medium'],
            ['label' => __( 'Author' ), 'class' => 'px-4 py-3 text-left font-medium'],
            ['label' => __( 'Updated' ), 'class' => 'px-4 py-3 text-left font-medium'],
            ['label' => __( 'Actions' ), 'class' => 'px-4 py-3 text-right font-medium'],
        ];
    }

    /**
     * @return list<array<string, mixed>>
     */
    public function columns(): array
    {
        return [
            ['data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'searchable' => false, 'orderable' => false, 'className' => 'w-14 text-left'],
            ['data' => 'title', 'name' => 'title'],
            ['data' => 'status', 'name' => 'status_id'],
            ['data' => 'author', 'name' => 'author'],
            ['data' => 'updated_at', 'name' => 'updated_at'],
            ['data' => 'action', 'name' => 'action', 'searchable' => false, 'orderable' => false, 'className' => 'text-right whitespace-nowrap'],
        ];
    }

    public function filterPlaceholder(): string
    {
        return __( 'Filter articles...' );
    }
}
