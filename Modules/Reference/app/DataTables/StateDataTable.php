<?php

declare(strict_types=1);

namespace Modules\Reference\DataTables;

use Illuminate\Http\JsonResponse;
use Modules\Reference\Models\State;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Database\Eloquent\Builder;
use App\Support\DataTable\BaseModuleDataTable;

class StateDataTable extends BaseModuleDataTable
{
    /**
     * @return Builder<State>
     */
    public function query(): Builder
    {
        return State::query()
            ->with(['createdBy', 'updatedBy'])
            ->ordered('sort', 'asc' );
    }

    public function ajax(): JsonResponse
    {
        return DataTables::eloquent( $this->query() )
            ->addIndexColumn()
            ->addColumn( 'status_label', static fn ( State $state ): string => view( 'modules.states.partials.datatables_status', [
                'state' => $state,
            ] )->render() )
            ->addColumn( 'action', static fn ( State $state ): string => view( 'modules.states.partials.datatables_actions', [
                'state' => $state,
            ] )->render() )
            ->editColumn('status', function ($q) {
                return $q->status ? 'Active' : 'Inactive';  
            })
            ->editColumn('created_at', function ($q) {
                $date = $q->created_at ? $q->created_at->format('d/m/Y H:i:s') : '';
                $user = $q->created_by ? $q->createdBy->name : '';
                return $date . ($user ? ' by ' . $user : '');
            })
            ->editColumn('updated_at', function ($q) {
                $date = $q->updated_at ? $q->updated_at->format('d/m/Y H:i:s') : '';
                $user = $q->updated_by ? $q->updatedBy->name : '';
                return $date . ($user ? ' by ' . $user : '');
            })

            ->rawColumns( ['status_label', 'action'] )
            ->toJson();
    }

    protected function tableId(): string
    {
        return 'states-table';
    }

    protected function ajaxRouteName(): string
    {
        return 'reference.states.index';
    }

    /**
     * @return list<array{label: string, class?: string}>
     */
    protected function headings(): array
    {
        return [
            ['label' => __('/modules/reference/state.fields.sort'), 'class' => 'px-4 py-3 text-left font-medium w-20'],
            ['label' => __( '/modules/reference/state.fields.name'), 'class' => 'px-4 py-3 text-left font-medium'],
            ['label' => __( '/modules/reference/state.fields.fullname'), 'class' => 'px-4 py-3 text-left font-medium'],
            ['label' => __( '/modules/reference/state.fields.status'), 'class' => 'px-4 py-3 text-left font-medium w-24'],
            ['label' => __( '/modules/reference/state.fields.created'), 'class' => 'px-4 py-3 text-left font-medium w-32'],
            ['label' => __( '/modules/reference/state.fields.updated'), 'class' => 'px-4 py-3 text-left font-medium w-32'],
            ['label' => __( 'crud.action' ), 'class' => 'px-4 py-3 text-right font-medium'],
        ];
    }

    /**
     * @return list<array<string, mixed>>
     */
    public function columns(): array
    {
        return [
            ['data' => 'sort', 'name' => 'sort', 'searchable' => false, 'orderable' => true, 'className' => 'w-14 text-left'],
            ['data' => 'name', 'name' => 'name'],
            ['data' => 'fullname', 'name' => 'fullname'],
            ['data' => 'status', 'name' => 'status'],
            ['data' => 'created_at', 'name' => 'created_at'],
            ['data' => 'updated_at', 'name' => 'updated_at'],
            ['data' => 'action', 'name' => 'action', 'searchable' => false, 'orderable' => false, 'className' => 'text-right whitespace-nowrap'],
        ];
    }

    public function filterPlaceholder(): string
    {
        return __( 'Filter states...' );
    }
}
