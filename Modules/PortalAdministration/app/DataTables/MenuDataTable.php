<?php

declare(strict_types=1);

namespace Modules\PortalAdministration\DataTables;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Database\Eloquent\Builder;
use Modules\PortalAdministration\Models\Menu;
use App\Support\DataTable\BaseModuleDataTable;

class MenuDataTable extends BaseModuleDataTable
{
    /**
     * @return Builder<Menu>
     */
    public function query(): Builder
    {
        // Dummy query — we override ajax() to use collection
        return Menu::query()->with( 'parent' );
    }

    public function ajax(): JsonResponse
    {
        // Build tree: parents ordered, then children under each parent ordered
        $parents = Menu::query()
            ->with( 'type' )
            ->whereNull( 'parent_id' )
            ->ordered()
            ->get();

        $rows = new Collection;

        foreach ( $parents as $parent ) {
            $rows->push( $parent );

            $children = Menu::query()
                ->with( 'type' )
                ->where( 'parent_id', $parent->id )
                ->ordered()
                ->get();

            foreach ( $children as $child ) {
                $child->setRelation( 'parent', $parent );
                $rows->push( $child );

                $grandchildren = Menu::query()
                    ->with( 'type' )
                    ->where( 'parent_id', $child->id )
                    ->ordered()
                    ->get();

                foreach ( $grandchildren as $grandchild ) {
                    $grandchild->setRelation( 'parent', $child );
                    $grandchild->setAttribute( 'depth', 2 );
                    $rows->push( $grandchild );
                }
            }
        }

        return DataTables::of( $rows )
            ->addIndexColumn()
            ->addColumn( 'sort_action', static fn ( Menu $menu ): string => view( 'portaladministration::menus.partials.datatables_sort_action', [
                'menu' => $menu,
            ] )->render() )
            ->addColumn( 'type_name', static fn ( Menu $menu ): string => $menu->type_id
                ? ( $menu->type?->label_my ?? $menu->type?->label_en ?? 'null' )
                : 'null' )
            ->addColumn( 'parent_name', static fn ( Menu $menu ): string => $menu->parent_id
                ? ( $menu->parent?->title_my ?? $menu->parent?->title_en ?? 'null' )
                : 'null' )
            ->addColumn( 'display_title_my', static function ( Menu $menu ): string {
                if ( ! $menu->parent_id ) {
                    return '<strong>' . ( $menu->title_my ?? '' ) . '</strong>';
                }

                if ( $menu->getAttribute( 'depth' ) === 2 ) {
                    return '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;↳ ' . ( $menu->title_my ?? '' );
                }

                return '&nbsp;&nbsp;&nbsp;&nbsp;↳ ' . ( $menu->title_my ?? '' );
            } )
            ->addColumn( 'display_title_en', static function ( Menu $menu ): string {
                if ( ! $menu->parent_id ) {
                    return '<strong>' . ( $menu->title_en ?? '' ) . '</strong>';
                }

                if ( $menu->getAttribute( 'depth' ) === 2 ) {
                    return '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;↳ ' . ( $menu->title_en ?? '' );
                }

                return '&nbsp;&nbsp;&nbsp;&nbsp;↳ ' . ( $menu->title_en ?? '' );
            } )
            ->addColumn( 'status_label', static fn ( Menu $menu ): string => view( 'portaladministration::menus.partials.datatables_status', [
                'menu' => $menu,
            ] )->render() )
            ->addColumn( 'action', static fn ( Menu $menu ): string => view( 'portaladministration::menus.partials.datatables_actions', [
                'menu' => $menu,
            ] )->render() )
            ->rawColumns( ['sort_action', 'display_title_my', 'display_title_en', 'status_label', 'action'] )
            ->toJson();
    }

    protected function tableId(): string
    {
        return 'menus-table';
    }

    protected function ajaxRouteName(): string
    {
        return 'portal-administration.menus.index';
    }

    /**
     * @return list<array{label: string, class?: string}>
     */
    protected function headings(): array
    {
        return [
            ['label' => __( 'modules/portal-administration/menu.fields.sort' ), 'class' => 'px-4 py-3 text-left font-medium w-20'],
            ['label' => __( 'modules/portal-administration/menu.fields.sort_action' ), 'class' => 'px-4 py-3 text-center font-medium w-24'],
            ['label' => __( 'modules/portal-administration/menu.fields.type' ), 'class' => 'px-4 py-3 text-left font-medium'],
            ['label' => __( 'modules/portal-administration/menu.fields.parent' ), 'class' => 'px-4 py-3 text-left font-medium'],
            ['label' => __( 'modules/portal-administration/menu.fields.title_my' ), 'class' => 'px-4 py-3 text-left font-medium'],
            ['label' => __( 'modules/portal-administration/menu.fields.title_en' ), 'class' => 'px-4 py-3 text-left font-medium'],
            ['label' => __( 'modules/portal-administration/menu.fields.status' ), 'class' => 'px-4 py-3 text-center font-medium w-28'],
            ['label' => __( 'modules/portal-administration/menu.fields.slug' ), 'class' => 'px-4 py-3 text-left font-medium'],
            ['label' => __( 'modules/portal-administration/menu.fields.url' ), 'class' => 'px-4 py-3 text-left font-medium'],
            ['label' => __( 'crud.action' ), 'class' => 'px-4 py-3 text-right font-medium'],
        ];
    }

    /**
     * @return list<array<string, mixed>>
     */
    public function columns(): array
    {
        return [
            ['data' => 'sort', 'name' => 'sort', 'className' => 'w-20 text-left', 'orderable' => false],
            ['data' => 'sort_action', 'name' => 'sort_action', 'searchable' => false, 'orderable' => false, 'className' => 'w-24 text-center'],
            ['data' => 'type_name', 'name' => 'type_name', 'orderable' => false],
            ['data' => 'parent_name', 'name' => 'parent_name', 'orderable' => false],
            ['data' => 'display_title_my', 'name' => 'title_my', 'orderable' => false],
            ['data' => 'display_title_en', 'name' => 'title_en', 'orderable' => false],
            ['data' => 'status_label', 'name' => 'status_id', 'searchable' => false, 'orderable' => false, 'className' => 'text-center'],
            ['data' => 'slug', 'name' => 'slug', 'orderable' => false],
            ['data' => 'url', 'name' => 'url', 'orderable' => false],
            ['data' => 'action', 'name' => 'action', 'searchable' => false, 'orderable' => false, 'className' => 'text-right whitespace-nowrap'],
        ];
    }

    public function filterPlaceholder(): string
    {
        return __( 'modules/portal-administration/menu.filter' );
    }
}
