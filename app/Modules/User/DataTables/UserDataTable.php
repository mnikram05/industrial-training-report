<?php

declare(strict_types=1);

namespace App\Modules\User\DataTables;

use App\Modules\User\Models\User;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Database\Eloquent\Builder;
use App\Support\DataTable\BaseModuleDataTable;

class UserDataTable extends BaseModuleDataTable
{
    /**
     * @return Builder<User>
     */
    public function query(): Builder
    {
        return User::query()->select( ['id', 'name', 'email', 'created_at'] );
    }

    public function ajax(): JsonResponse
    {
        return DataTables::eloquent( $this->query() )
            ->addIndexColumn()
            ->editColumn( 'created_at', static fn ( User $user ): string => $user->created_at?->format( 'M j, Y' ) ?? '—' )
            ->addColumn( 'action', static fn ( User $user ): string => view( 'modules.users.partials.datatables_actions', [
                'user'           => $user,
                'canImpersonate' => function_exists( 'can_be_impersonated' ) && can_be_impersonated( $user ),
            ] )->render() )
            ->rawColumns( ['action'] )
            ->toJson();
    }

    protected function tableId(): string
    {
        return 'users-table';
    }

    protected function ajaxRouteName(): string
    {
        return 'users.index';
    }

    /**
     * @return list<array{label: string, class?: string}>
     */
    protected function headings(): array
    {
        return [
            ['label' => __( 'ui.no_fbd39f' ), 'class' => 'px-4 py-3 text-left font-medium w-14'],
            ['label' => __( 'ui.name' ), 'class' => 'px-4 py-3 text-left font-medium'],
            ['label' => __( 'ui.email' ), 'class' => 'px-4 py-3 text-left font-medium'],
            ['label' => __( 'ui.created' ), 'class' => 'px-4 py-3 text-left font-medium'],
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
            ['data' => 'email', 'name' => 'email'],
            ['data' => 'created_at', 'name' => 'created_at'],
            ['data' => 'action', 'name' => 'action', 'searchable' => false, 'orderable' => false, 'className' => 'text-right whitespace-nowrap'],
        ];
    }

    public function filterPlaceholder(): string
    {
        return __( 'ui.filter_users' );
    }
}
