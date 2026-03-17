<?php

declare(strict_types=1);

namespace Modules\Reference\DataTables;

use Illuminate\Http\JsonResponse;
use Modules\Reference\Models\Menu;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Database\Eloquent\Builder;
use App\Support\DataTable\BaseModuleDataTable;

class MenuDataTable extends BaseModuleDataTable
{
    /**
     * @return Builder<Menu>
     */
    public function query(): Builder
    {
        return Menu::query()
            ->with( ['parent', 'createdBy', 'updatedBy'] )
            ->ordered();
    }

    public function ajax(): JsonResponse
    {
        return DataTables::eloquent( $this->query() )
            ->addIndexColumn()
            ->addColumn( 'sort_action', static fn ( Menu $menu ): string => view( 'reference::menus.partials.datatables_sort_action', [
                'menu' => $menu,
            ] )->render() )
            ->addColumn( 'status_label', static fn ( Menu $menu ): string => view( 'reference::menus.partials.datatables_status', [
                'menu' => $menu,
            ] )->render() )
            ->addColumn( 'parent_name', static fn ( Menu $menu ): string => $menu->parent?->title_en ?? '' )
            ->addColumn( 'action', static fn ( Menu $menu ): string => view( 'reference::menus.partials.datatables_actions', [
                'menu' => $menu,
            ] )->render() )
            ->editColumn( 'status_id', function ( $q ) {
                return $q->status_id ? 'Active' : 'Inactive';
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
        return 'menus-table';
    }

    protected function ajaxRouteName(): string
    {
        return 'reference.menus.index';
    }

    /**
     * @return list<array{label: string, class?: string}>
     */
    protected function headings(): array
    {
        return [
            ['label' => __( 'modules/reference/menu.fields.sort' ), 'class' => 'px-4 py-3 text-left font-medium w-20'],
            ['label' => __( 'modules/reference/menu.fields.sort_action' ), 'class' => 'px-4 py-3 text-center font-medium w-24'],
            ['label' => __( 'modules/reference/menu.fields.title_en' ), 'class' => 'px-4 py-3 text-left font-medium'],
            ['label' => __( 'modules/reference/menu.fields.parent' ), 'class' => 'px-4 py-3 text-left font-medium'],
            ['label' => __( 'modules/reference/menu.fields.url' ), 'class' => 'px-4 py-3 text-left font-medium'],
            ['label' => __( 'modules/reference/menu.fields.status' ), 'class' => 'px-4 py-3 text-left font-medium w-24'],
            ['label' => __( 'modules/reference/menu.fields.created' ), 'class' => 'px-4 py-3 text-left font-medium w-32'],
            ['label' => __( 'modules/reference/menu.fields.updated' ), 'class' => 'px-4 py-3 text-left font-medium w-32'],
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
            ['data' => 'title_en', 'name' => 'title_en'],
            ['data' => 'parent_name', 'name' => 'parent_name'],
            ['data' => 'url', 'name' => 'url'],
            ['data' => 'status_id', 'name' => 'status_id'],
            ['data' => 'created_at', 'name' => 'created_at'],
            ['data' => 'updated_at', 'name' => 'updated_at'],
            ['data' => 'action', 'name' => 'action', 'searchable' => false, 'orderable' => false, 'className' => 'text-right whitespace-nowrap'],
        ];
    }

    public function filterPlaceholder(): string
    {
        return __( 'modules/reference/menu.filter' );
    }
}
