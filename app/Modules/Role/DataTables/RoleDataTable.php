<?php

declare(strict_types=1);

namespace App\Modules\Role\DataTables;

use Illuminate\Http\JsonResponse;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Database\Eloquent\Builder;
use App\Support\DataTable\BaseModuleDataTable;

class RoleDataTable extends BaseModuleDataTable
{
    /**
     * @return Builder<Role>
     */
    public function query(): Builder
    {
        return Role::query()->select( ['id', 'name', 'guard_name'] );
    }

    public function ajax(): JsonResponse
    {
        return DataTables::eloquent( $this->query() )
            ->addIndexColumn()
            ->addColumn( 'action', static fn ( Role $role ): string => view( 'modules.roles.partials.datatables_actions', [
                'role' => $role,
            ] )->render() )
            ->rawColumns( ['action'] )
            ->toJson();
    }

    protected function tableId(): string
    {
        return 'roles-table';
    }

    protected function ajaxRouteName(): string
    {
        return 'roles.data';
    }

    /**
     * @return list<array{label: string, class?: string}>
     */
    protected function headings(): array
    {
        return [
            ['label' => __( 'ui.no_fbd39f' ), 'class' => 'px-4 py-3 text-left font-medium w-14'],
            ['label' => __( 'ui.name' ), 'class' => 'px-4 py-3 text-left font-medium'],
            ['label' => __( 'ui.guard' ), 'class' => 'px-4 py-3 text-left font-medium'],
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
            ['data' => 'name', 'name' => 'name'],
            ['data' => 'guard_name', 'name' => 'guard_name'],
            ['data' => 'action', 'name' => 'action', 'searchable' => false, 'orderable' => false, 'className' => 'text-right whitespace-nowrap'],
        ];
    }

    public function filterPlaceholder(): string
    {
        return __( 'ui.filter_roles' );
    }
}
