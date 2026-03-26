<?php

declare(strict_types=1);

namespace Modules\Reference\DataTables;

use Illuminate\Http\JsonResponse;
use Modules\Reference\Models\Dun;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Database\Eloquent\Builder;
use App\Support\DataTable\BaseModuleDataTable;

class DunDataTable extends BaseModuleDataTable
{
    protected ?int $parliamentId = null;

    public function setParliamentId( ?int $parliamentId ): static
    {
        $this->parliamentId = $parliamentId;

        return $this;
    }

    /**
     * @return Builder<Dun>
     */
    public function query(): Builder
    {
        return Dun::query()
            ->with( ['parliament', 'createdBy', 'updatedBy'] )
            ->when( $this->parliamentId, fn ( Builder $q ) => $q->where( 'parliament_id', $this->parliamentId ) )
            ->ordered();
    }

    public function ajax(): JsonResponse
    {
        return DataTables::eloquent( $this->query() )
            ->addIndexColumn()
            ->addColumn( 'sort_action', static fn ( Dun $dun ): string => view( 'reference::duns.partials.datatables_sort_action', [
                'dun' => $dun,
            ] )->render() )
            ->addColumn( 'status_label', static fn ( Dun $dun ): string => view( 'reference::duns.partials.datatables_status', [
                'dun' => $dun,
            ] )->render() )
            ->addColumn( 'parliament_name', static fn ( Dun $dun ): string => $dun->parliament?->name ?? '' )
            ->addColumn( 'action', static fn ( Dun $dun ): string => view( 'reference::duns.partials.datatables_actions', [
                'dun' => $dun,
            ] )->render() )
            ->editColumn( 'status', function ( $q ) {
                return $q->status ? 'Active' : 'Inactive';
            } )
            ->editColumn( 'created_at', function ( $q ) {
                $date = $q->created_at ? $q->created_at->format( 'd/m/Y H:i:s' ) : '';
                $user = $q->created_by ? $q->createdBy->name : '';

                return $date . ( $user ? ' by ' . $user : '' );
            } )
            ->editColumn( 'updated_at', function ( $q ) {
                $date = $q->updated_at ? $q->updated_at->format( 'd/m/Y H:i:s' ) : '';
                $user = $q->updated_by ? $q->updatedBy->name : '';

                return $date . ( $user ? ' by ' . $user : '' );
            } )

            ->rawColumns( ['sort_action', 'status_label', 'action'] )
            ->toJson();
    }

    protected function tableId(): string
    {
        return 'duns-table';
    }

    protected function ajaxRouteName(): string
    {
        return 'reference.duns.index';
    }

    public function ajaxUrl(): string
    {
        return route( $this->ajaxRouteName(), array_filter( ['parliament_id' => $this->parliamentId] ) );
    }

    /**
     * @return list<array{label: string, class?: string}>
     */
    protected function headings(): array
    {
        return [
            ['label' => __( 'modules/reference/dun.fields.sort' ), 'class' => 'px-4 py-3 text-left font-medium w-20'],
            ['label' => __( 'modules/reference/dun.fields.sort_action' ), 'class' => 'px-4 py-3 text-center font-medium w-24'],
            ['label' => __( 'modules/reference/dun.fields.name' ), 'class' => 'px-4 py-3 text-left font-medium'],
            ['label' => __( 'modules/reference/dun.fields.parliament' ), 'class' => 'px-4 py-3 text-left font-medium'],
            ['label' => __( 'modules/reference/dun.fields.status' ), 'class' => 'px-4 py-3 text-left font-medium w-24'],
            ['label' => __( 'modules/reference/dun.fields.created' ), 'class' => 'px-4 py-3 text-left font-medium w-32'],
            ['label' => __( 'modules/reference/dun.fields.updated' ), 'class' => 'px-4 py-3 text-left font-medium w-32'],
            ['label' => __( 'crud.action' ), 'class' => 'px-4 py-3 text-right font-medium'],
        ];
    }

    /**
     * @return list<array<string, mixed>>
     */
    public function columns(): array
    {
        return [
            ['data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'searchable' => false, 'orderable' => false, 'className' => 'w-14 text-left'],
            ['data' => 'sort_action', 'name' => 'sort', 'searchable' => false, 'orderable' => false, 'className' => 'w-24 text-center'],
            ['data' => 'name', 'name' => 'name'],
            ['data' => 'parliament_name', 'name' => 'parliament_name'],
            ['data' => 'status_label', 'name' => 'status', 'searchable' => false, 'orderable' => false],
            ['data' => 'created_at', 'name' => 'created_at'],
            ['data' => 'updated_at', 'name' => 'updated_at'],
            ['data' => 'action', 'name' => 'action', 'searchable' => false, 'orderable' => false, 'className' => 'text-right whitespace-nowrap'],
        ];
    }

    public function filterPlaceholder(): string
    {
        return __( 'modules/reference/dun.filter' );
    }
}
