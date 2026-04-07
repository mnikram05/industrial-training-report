<?php

declare(strict_types=1);

namespace Modules\Reference\DataTables;

use Illuminate\Http\JsonResponse;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Database\Eloquent\Builder;
use Modules\Reference\Models\DataReference;
use App\Support\DataTable\BaseModuleDataTable;

class DataReferenceDataTable extends BaseModuleDataTable
{
    /**
     * @return Builder<DataReference>
     */
    public function query(): Builder
    {
        return DataReference::query()
            ->whereNull( 'parent_id' )
            ->withCount( 'children' )
            ->ordered();
    }

    public function ajax(): JsonResponse
    {
        return DataTables::eloquent( $this->query() )
            ->addIndexColumn()
            ->addColumn( 'status_toggle', static fn ( DataReference $dataReference ): string => view( 'reference::data-references.partials.datatables_status_toggle', [
                'dataReference' => $dataReference,
            ] )->render() )
            ->addColumn( 'action', static fn ( DataReference $dataReference ): string => view( 'reference::data-references.partials.datatables_actions', [
                'dataReference' => $dataReference,
            ] )->render() )
            ->rawColumns( ['status_toggle', 'action'] )
            ->toJson();
    }

    protected function tableId(): string
    {
        return 'data-references-table';
    }

    protected function ajaxRouteName(): string
    {
        return 'reference.data-references.data';
    }

    /**
     * @return list<array{label: string, class?: string}>
     */
    protected function headings(): array
    {
        return [
            ['label' => '#', 'class' => 'px-4 py-3 text-left font-medium w-14'],
            ['label' => __( 'modules/reference/data-reference.fields.label_ms' ), 'class' => 'px-4 py-3 text-left font-medium'],
            ['label' => __( 'modules/reference/data-reference.fields.label_en' ), 'class' => 'px-4 py-3 text-left font-medium'],
            ['label' => __( 'modules/reference/data-reference.fields.description' ), 'class' => 'px-4 py-3 text-left font-medium'],
            ['label' => __( 'modules/reference/data-reference.fields.status' ), 'class' => 'px-4 py-3 text-center font-medium w-28'],
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
            ['data' => 'label_ms', 'name' => 'label_ms'],
            ['data' => 'label_en', 'name' => 'label_en'],
            ['data' => 'description', 'name' => 'description'],
            ['data' => 'status_toggle', 'name' => 'status', 'searchable' => false, 'orderable' => false, 'className' => 'text-center'],
            ['data' => 'action', 'name' => 'action', 'searchable' => false, 'orderable' => false, 'className' => 'text-right whitespace-nowrap'],
        ];
    }

    public function filterPlaceholder(): string
    {
        return __( 'modules/reference/data-reference.filter' );
    }
}
