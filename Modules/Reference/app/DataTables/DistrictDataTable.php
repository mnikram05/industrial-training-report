<?php

declare(strict_types=1);

namespace Modules\Reference\DataTables;

use Illuminate\Http\JsonResponse;
use Modules\Reference\Models\District;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Database\Eloquent\Builder;
use App\Support\DataTable\BaseModuleDataTable;

class DistrictDataTable extends BaseModuleDataTable
{
    /**
     * @return Builder<District>
     */
    public function query(): Builder
    {
        return District::query()
            ->with( 'state' )
            ->select( ['id', 'state_id', 'ddsa_code', 'name', 'fullname', 'sort'] )
            ->ordered();
    }

    public function ajax(): JsonResponse
    {
        return DataTables::eloquent( $this->query() )
            ->addIndexColumn()
            ->addColumn( 'state_name', static fn ( District $district ): string => $district->state?->name ?? '—' )
            ->addColumn( 'action', static fn ( District $district ): string => view( 'modules.districts.partials.datatables_actions', [
                'district' => $district,
            ] )->render() )
            ->filterColumn( 'state_name', static function ( Builder $query, string $keyword ): void {
                $query->whereHas( 'state', fn ( Builder $q ) => $q->where( 'name', 'like', "%{$keyword}%" ) );
            } )
            ->rawColumns( ['action'] )
            ->toJson();
    }

    protected function tableId(): string
    {
        return 'districts-table';
    }

    protected function ajaxRouteName(): string
    {
        return 'reference.districts.index';
    }

    /**
     * @return list<array{label: string, class?: string}>
     */
    protected function headings(): array
    {
        return [
            ['label' => __( 'No.' ), 'class' => 'px-4 py-3 text-left font-medium w-14'],
            ['label' => __( 'DDSA Code' ), 'class' => 'px-4 py-3 text-left font-medium'],
            ['label' => __( 'Name' ), 'class' => 'px-4 py-3 text-left font-medium'],
            ['label' => __( 'Full Name' ), 'class' => 'px-4 py-3 text-left font-medium'],
            ['label' => __( 'State' ), 'class' => 'px-4 py-3 text-left font-medium'],
            ['label' => __( 'Sort' ), 'class' => 'px-4 py-3 text-left font-medium w-20'],
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
            ['data' => 'ddsa_code', 'name' => 'ddsa_code'],
            ['data' => 'name', 'name' => 'name'],
            ['data' => 'fullname', 'name' => 'fullname'],
            ['data' => 'state_name', 'name' => 'state_name'],
            ['data' => 'sort', 'name' => 'sort'],
            ['data' => 'action', 'name' => 'action', 'searchable' => false, 'orderable' => false, 'className' => 'text-right whitespace-nowrap'],
        ];
    }

    public function filterPlaceholder(): string
    {
        return __( 'Filter districts...' );
    }
}
