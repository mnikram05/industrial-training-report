<?php

declare(strict_types=1);

namespace App\Modules\User\DataTables;

use App\Modules\User\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
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
        return User::query()->select( ['id', 'name', 'email', 'approved_at', 'rejected_at', 'requested_role', 'created_at'] );
    }

    public function ajax(): JsonResponse
    {
        return DataTables::eloquent( $this->query() )
            ->addIndexColumn()
            ->addColumn( 'registration_status', static function ( User $user ): string {
                if ( $user->isPendingRegistrationApproval() ) {
                    $roleKey = is_string( $user->requested_role ) && $user->requested_role !== ''
                        ? $user->requested_role
                        : '—';

                    $roleLabel = $roleKey === '—' ? '—' : Str::headline( $roleKey );

                    return '<span class="inline-flex items-center rounded-full bg-amber-500/15 px-2 py-0.5 text-xs font-medium text-amber-800 ring-1 ring-inset ring-amber-600/20 dark:bg-amber-400/10 dark:text-amber-300 dark:ring-amber-400/30">'
                        . e( __( 'modules/login.register.pending_badge' ) )
                        . '</span>'
                        . ' <span class="text-muted-foreground text-xs">' . e( $roleLabel ) . '</span>';
                }

                if ( $user->isRejected() ) {
                    return '<span class="inline-flex items-center rounded-full bg-red-500/15 px-2 py-0.5 text-xs font-medium text-red-800 ring-1 ring-inset ring-red-600/20 dark:bg-red-400/10 dark:text-red-300 dark:ring-red-400/30">'
                        . e( __( 'modules/login.register.rejected_badge' ) )
                        . '</span>';
                }

                return '<span class="text-muted-foreground text-sm">' . e( __( 'ui.approved' ) ) . '</span>';
            } )
            ->editColumn( 'created_at', static fn ( User $user ): string => $user->created_at?->format( 'M j, Y' ) ?? '—' )
            ->addColumn( 'action', static fn ( User $user ): string => view( 'modules.users.partials.datatables_actions', [
                'user'           => $user,
                'canImpersonate' => function_exists( 'can_be_impersonated' ) && can_be_impersonated( $user ),
            ] )->render() )
            ->rawColumns( ['registration_status', 'action'] )
            ->toJson();
    }

    protected function tableId(): string
    {
        return 'users-table';
    }

    protected function ajaxRouteName(): string
    {
        return 'users.data';
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
            ['label' => __( 'modules/login.register.registration_column' ), 'class' => 'px-4 py-3 text-left font-medium'],
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
            ['data' => 'registration_status', 'name' => 'registration_status', 'searchable' => false, 'orderable' => false],
            ['data' => 'created_at', 'name' => 'created_at'],
            ['data' => 'action', 'name' => 'action', 'searchable' => false, 'orderable' => false, 'className' => 'text-right whitespace-nowrap'],
        ];
    }

    public function filterPlaceholder(): string
    {
        return __( 'ui.filter_users' );
    }
}
