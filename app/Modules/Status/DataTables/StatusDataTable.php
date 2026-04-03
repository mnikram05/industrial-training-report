<?php

declare(strict_types=1);

namespace App\Modules\Status\DataTables;

use App\Support\Status\Status;
use Illuminate\Http\JsonResponse;
use App\Support\Status\StatusType;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Database\Eloquent\Builder;
use App\Support\DataTable\BaseModuleDataTable;

class StatusDataTable extends BaseModuleDataTable
{
    private bool $moduleParentsOnly = false;

    private ?int $parentStatusId = null;

    public function onlyModuleParents(): self
    {
        $this->moduleParentsOnly = true;
        $this->parentStatusId    = null;

        return $this;
    }

    public function forParentStatus( Status $status ): self
    {
        $this->moduleParentsOnly = false;
        $this->parentStatusId    = (int) $status->id;

        return $this;
    }

    /**
     * @return Builder<Status>
     */
    public function query(): Builder
    {
        $query = Status::query()
            ->select( ['id', 'type', 'key', 'parent_id', 'name_en', 'name_ms'] )
            ->with( 'parent:id,key,name_en,name_ms' );

        if ( $this->moduleParentsOnly ) {
            $query->where( 'type', StatusType::Module->value )
                ->whereNull( 'parent_id' );
        }

        if ( is_int( $this->parentStatusId ) ) {
            $query->where( 'parent_id', $this->parentStatusId );
        }

        return $query;
    }

    public function ajax(): JsonResponse
    {
        return DataTables::eloquent( $this->query() )
            ->addIndexColumn()
            ->addColumn( 'action', fn ( Status $status ): string => view( 'modules.statuses.partials.datatables_actions', [
                'status'  => $status,
                'showUrl' => $this->moduleParentsOnly ? route( 'statuses.show', $status ) : null,
            ] )->render() )
            ->rawColumns( ['action'] )
            ->toJson();
    }

    public function ajaxUrl(): string
    {
        if ( is_int( $this->parentStatusId ) ) {
            return route( 'statuses.show', ['status' => $this->parentStatusId] );
        }

        return parent::ajaxUrl();
    }

    protected function tableId(): string
    {
        return 'statuses-table';
    }

    protected function ajaxRouteName(): string
    {
        return 'statuses.index';
    }

    /**
     * @return list<array{label: string, class?: string}>
     */
    protected function headings(): array
    {
        return [
            ['label' => __( 'ui.no_fbd39f' ), 'class' => 'px-4 py-3 text-left font-medium w-14'],
            ['label' => __( 'ui.status_key' ), 'class' => 'px-4 py-3 text-left font-medium'],
            ['label' => __( 'ui.name_english' ), 'class' => 'px-4 py-3 text-left font-medium'],
            ['label' => __( 'ui.name_malay' ), 'class' => 'px-4 py-3 text-left font-medium'],
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
            ['data' => 'key', 'name' => 'key'],
            ['data' => 'name_en', 'name' => 'name_en'],
            ['data' => 'name_ms', 'name' => 'name_ms'],
            ['data' => 'action', 'name' => 'action', 'searchable' => false, 'orderable' => false, 'className' => 'text-right whitespace-nowrap'],
        ];
    }

    public function filterPlaceholder(): string
    {
        return $this->moduleParentsOnly
            ? __( 'ui.filter_modules' )
            : __( 'ui.filter_statuses' );
    }
}
