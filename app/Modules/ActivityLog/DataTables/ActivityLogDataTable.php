<?php

declare(strict_types=1);

namespace App\Modules\ActivityLog\DataTables;

use Illuminate\Http\JsonResponse;
use Spatie\Activitylog\Models\Activity;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Database\Eloquent\Builder;
use App\Support\DataTable\BaseModuleDataTable;

class ActivityLogDataTable extends BaseModuleDataTable
{
    /**
     * @return Builder<Activity>
     */
    public function query(): Builder
    {
        return Activity::query()
            ->select( ['id', 'event', 'description', 'causer_id', 'created_at'] )
            ->with( 'causer:id,name' )
            ->latest();
    }

    public function ajax(): JsonResponse
    {
        return DataTables::eloquent( $this->query() )
            ->addIndexColumn()
            ->editColumn( 'event', static fn ( Activity $activity ): string => $activity->event ?: '—' )
            ->addColumn( 'causer', static function ( Activity $activity ): string {
                $causerName = data_get( $activity, 'causer.name' );

                return is_string( $causerName ) && $causerName !== ''
                    ? $causerName
                    : __( 'System' );
            } )
            ->editColumn( 'created_at', static fn ( Activity $activity ): string => $activity->created_at?->diffForHumans() ?? '—' )
            ->addColumn( 'action', static fn ( Activity $activity ): string => view(
                'modules.activity-logs.partials.datatables_actions',
                ['activity' => $activity]
            )->render() )
            ->rawColumns( ['action'] )
            ->toJson();
    }

    protected function tableId(): string
    {
        return 'activity-logs-table';
    }

    protected function ajaxRouteName(): string
    {
        return 'activity-logs.index';
    }

    /**
     * @return list<array{label: string, class?: string}>
     */
    protected function headings(): array
    {
        return [
            ['label' => __( 'No.' ), 'class' => 'px-4 py-3 text-left font-medium w-14'],
            ['label' => __( 'Event' ), 'class' => 'px-4 py-3 text-left font-medium'],
            ['label' => __( 'Description' ), 'class' => 'px-4 py-3 text-left font-medium'],
            ['label' => __( 'Causer' ), 'class' => 'px-4 py-3 text-left font-medium'],
            ['label' => __( 'When' ), 'class' => 'px-4 py-3 text-left font-medium'],
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
            ['data' => 'event', 'name' => 'event'],
            ['data' => 'description', 'name' => 'description'],
            ['data' => 'causer', 'name' => 'causer'],
            ['data' => 'created_at', 'name' => 'created_at'],
            ['data' => 'action', 'name' => 'action', 'searchable' => false, 'orderable' => false, 'className' => 'text-right whitespace-nowrap'],
        ];
    }

    public function filterPlaceholder(): string
    {
        return __( 'Filter activities...' );
    }
}
