<?php

declare(strict_types=1);

namespace App\Modules\Landing\DataTables;

use Illuminate\Http\JsonResponse;
use App\Modules\Landing\Models\Landing;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Database\Eloquent\Builder;
use App\Support\DataTable\BaseModuleDataTable;

class LandingDataTable extends BaseModuleDataTable
{
    /**
     * @return Builder<Landing>
     */
    public function query(): Builder
    {
        return Landing::query()->select( ['id', 'slug', 'content', 'status_id', 'updated_at'] );
    }

    public function ajax(): JsonResponse
    {
        return DataTables::eloquent( $this->query() )
            ->addIndexColumn()
            ->addColumn( 'title', static fn ( Landing $landing ): string => $landing->localizedName() )
            ->addColumn( 'status', static fn ( Landing $landing ): string => view( 'modules.landings.partials.datatables_published', [
                'landing' => $landing,
            ] )->render() )
            ->editColumn( 'updated_at', static fn ( Landing $landing ): string => $landing->updated_at?->format( 'M j, Y' ) ?? '—' )
            ->addColumn( 'action', static fn ( Landing $landing ): string => view( 'modules.landings.partials.datatables_actions', [
                'landing' => $landing,
            ] )->render() )
            ->filterColumn( 'title', static function ( Builder $query, string $keyword ): void {
                $query->where( function ( Builder $nestedQuery ) use ( $keyword ): void {
                    $nestedQuery->where( 'content', 'like', '%' . $keyword . '%' )
                        ->orWhere( 'slug', 'like', '%' . $keyword . '%' );
                } );
            } )
            ->rawColumns( ['status', 'action'] )
            ->toJson();
    }

    protected function tableId(): string
    {
        return 'landings-table';
    }

    protected function ajaxRouteName(): string
    {
        return 'landings.data';
    }

    /**
     * @return list<array{label: string, class?: string}>
     */
    protected function headings(): array
    {
        return [
            ['label' => __( 'ui.no_fbd39f' ), 'class' => 'px-4 py-3 text-left font-medium w-14'],
            ['label' => __( 'ui.title' ), 'class' => 'px-4 py-3 text-left font-medium'],
            ['label' => __( 'ui.slug' ), 'class' => 'px-4 py-3 text-left font-medium'],
            ['label' => __( 'ui.status' ), 'class' => 'px-4 py-3 text-left font-medium'],
            ['label' => __( 'ui.updated' ), 'class' => 'px-4 py-3 text-left font-medium'],
            ['label' => __( 'ui.actions' ), 'class' => 'px-4 py-3 text-right font-medium'],
        ];
    }

    /**
     * @return list<array<string, mixed>>
     */
    public function columns(): array
    {
        return [
            ['data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'searchable' => false, 'orderable' => false, 'className' => 'w-14 text-left'],
            ['data' => 'title', 'name' => 'content'],
            ['data' => 'slug', 'name' => 'slug'],
            ['data' => 'status', 'name' => 'status_id'],
            ['data' => 'updated_at', 'name' => 'updated_at'],
            ['data' => 'action', 'name' => 'action', 'searchable' => false, 'orderable' => false, 'className' => 'text-right whitespace-nowrap'],
        ];
    }

    public function filterPlaceholder(): string
    {
        return __( 'ui.filter_landings' );
    }
}
