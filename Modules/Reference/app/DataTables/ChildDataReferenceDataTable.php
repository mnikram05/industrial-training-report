<?php

declare(strict_types=1);

namespace Modules\Reference\DataTables;

use Illuminate\Http\JsonResponse;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Database\Eloquent\Builder;
use Modules\Reference\Models\DataReference;
use App\Support\DataTable\BaseModuleDataTable;

class ChildDataReferenceDataTable extends BaseModuleDataTable
{
    protected int $parentId;

    public function setParentId( int $parentId ): static
    {
        $this->parentId = $parentId;

        return $this;
    }

    /**
     * @return Builder<DataReference>
     */
    public function query(): Builder
    {
        return DataReference::query()
            ->where( 'parent_id', $this->parentId )
            ->ordered();
    }

    public function ajax(): JsonResponse
    {
        return DataTables::eloquent( $this->query() )
            ->addIndexColumn()
            ->addColumn( 'sort_action', fn ( DataReference $dataReference ): string => view( 'reference::data-references.partials.datatables_child_sort_action', [
                'dataReference' => $dataReference,
                'parentId'      => $this->parentId,
            ] )->render() )
            ->addColumn( 'status_toggle', static fn ( DataReference $dataReference ): string => view( 'reference::data-references.partials.datatables_child_status_toggle', [
                'dataReference' => $dataReference,
            ] )->render() )
            ->addColumn( 'action', static fn ( DataReference $dataReference ): string => view( 'reference::data-references.partials.datatables_child_actions', [
                'dataReference' => $dataReference,
            ] )->render() )
            ->rawColumns( ['sort_action', 'status_toggle', 'action'] )
            ->toJson();
    }

    protected function tableId(): string
    {
        return 'child-data-references-table';
    }

    protected function ajaxRouteName(): string
    {
        return 'reference.data-references.children';
    }

    public function ajaxUrl(): string
    {
        return route( $this->ajaxRouteName(), ['data_reference' => $this->parentId] );
    }

    /**
     * @return list<array{label: string, class?: string}>
     */
    protected function headings(): array
    {
        return [
            ['label' => __( 'modules/reference/data-reference.fields.sort' ), 'class' => 'px-4 py-3 text-left font-medium w-20'],
            ['label' => __( 'modules/reference/data-reference.fields.sort_action' ), 'class' => 'px-4 py-3 text-center font-medium w-24'],
            ['label' => __( 'modules/reference/data-reference.fields.label_my' ), 'class' => 'px-4 py-3 text-left font-medium'],
            ['label' => __( 'modules/reference/data-reference.fields.label_en' ), 'class' => 'px-4 py-3 text-left font-medium'],
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
            ['data' => 'sort', 'name' => 'sort', 'className' => 'w-20 text-left'],
            ['data' => 'sort_action', 'name' => 'sort_action', 'searchable' => false, 'orderable' => false, 'className' => 'w-24 text-center'],
            ['data' => 'label_my', 'name' => 'label_my'],
            ['data' => 'label_en', 'name' => 'label_en'],
            ['data' => 'status_toggle', 'name' => 'status', 'searchable' => false, 'orderable' => false, 'className' => 'text-center'],
            ['data' => 'action', 'name' => 'action', 'searchable' => false, 'orderable' => false, 'className' => 'text-right whitespace-nowrap'],
        ];
    }

    public function filterPlaceholder(): string
    {
        return __( 'modules/reference/data-reference.filter' );
    }
}
