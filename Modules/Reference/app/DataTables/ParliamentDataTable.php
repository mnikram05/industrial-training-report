<?php

declare(strict_types=1);

namespace Modules\Reference\DataTables;

use Illuminate\Http\JsonResponse;
use Modules\Reference\Models\Parliament;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Database\Eloquent\Builder;
use App\Support\DataTable\BaseModuleDataTable;

class ParliamentDataTable extends BaseModuleDataTable
{
    protected ?int $stateId = null;

    public function setStateId( ?int $stateId ): static
    {
        $this->stateId = $stateId;

        return $this;
    }

    /**
     * @return Builder<Parliament>
     */
    public function query(): Builder
    {
        return Parliament::query()
            ->with( ['state', 'createdBy', 'updatedBy'] )
            ->when( $this->stateId, fn ( Builder $q ) => $q->where( 'state_id', $this->stateId ) )
            ->ordered();
    }

    public function ajax(): JsonResponse
    {
        return DataTables::eloquent( $this->query() )
            ->addIndexColumn()
            ->addColumn( 'sort_action', static fn ( Parliament $parliament ): string => view( 'reference::parliaments.partials.datatables_sort_action', [
                'parliament' => $parliament,
            ] )->render() )
            ->addColumn( 'status_label', static fn ( Parliament $parliament ): string => view( 'reference::parliaments.partials.datatables_status', [
                'parliament' => $parliament,
            ] )->render() )
            ->addColumn( 'state_name', static fn ( Parliament $parliament ): string => $parliament->state?->name ?? '' )
            ->addColumn( 'action', static fn ( Parliament $parliament ): string => view( 'reference::parliaments.partials.datatables_actions', [
                'parliament' => $parliament,
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
        return 'parliaments-table';
    }

    protected function ajaxRouteName(): string
    {
        return 'reference.parliaments.data';
    }

    public function ajaxUrl(): string
    {
        return route( $this->ajaxRouteName(), array_filter( ['state_id' => $this->stateId] ) );
    }

    /**
     * @return list<array{label: string, class?: string}>
     */
    protected function headings(): array
    {
        return [
            ['label' => __( 'modules/reference/parliament.fields.sort' ), 'class' => 'px-4 py-3 text-left font-medium w-20'],
            ['label' => __( 'modules/reference/parliament.fields.sort_action' ), 'class' => 'px-4 py-3 text-center font-medium w-24'],
            ['label' => __( 'modules/reference/parliament.fields.name' ), 'class' => 'px-4 py-3 text-left font-medium'],
            ['label' => __( 'modules/reference/parliament.fields.state' ), 'class' => 'px-4 py-3 text-left font-medium'],
            ['label' => __( 'modules/reference/parliament.fields.status' ), 'class' => 'px-4 py-3 text-left font-medium w-24'],
            ['label' => __( 'modules/reference/parliament.fields.created' ), 'class' => 'px-4 py-3 text-left font-medium w-32'],
            ['label' => __( 'modules/reference/parliament.fields.updated' ), 'class' => 'px-4 py-3 text-left font-medium w-32'],
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
            ['data' => 'state_name', 'name' => 'state_name'],
            ['data' => 'status_label', 'name' => 'status', 'searchable' => false, 'orderable' => false],
            ['data' => 'created_at', 'name' => 'created_at'],
            ['data' => 'updated_at', 'name' => 'updated_at'],
            ['data' => 'action', 'name' => 'action', 'searchable' => false, 'orderable' => false, 'className' => 'text-right whitespace-nowrap'],
        ];
    }

    public function filterPlaceholder(): string
    {
        return __( 'modules/reference/parliament.filter' );
    }
}
