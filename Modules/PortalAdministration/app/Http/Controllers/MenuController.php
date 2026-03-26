<?php

declare(strict_types=1);

namespace Modules\PortalAdministration\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Modules\Reference\Models\DataReference;
use Modules\PortalAdministration\Models\Menu;
use Modules\PortalAdministration\DataTables\MenuDataTable;
use Modules\PortalAdministration\Http\Requests\StoreMenuRequest;
use Modules\PortalAdministration\Http\Requests\UpdateMenuRequest;

class MenuController extends Controller
{
    public function __construct(
        protected MenuDataTable $menuDataTable,
    ) {}

    /**
     * Display a listing of menus.
     */
    public function index( Request $request ): JsonResponse|View
    {
        if ( $request->ajax() ) {
            return $this->menuDataTable->ajax();
        }

        return view( 'portaladministration::menus.index', [
            'dataTable' => $this->menuDataTable,
        ] );
    }

    /**
     * Show the form for creating a new menu.
     */
    public function create(): View
    {
        return view( 'portaladministration::menus.create', [
            'parentOptions' => $this->getParentOptions(),
            'sortOptions'   => $this->buildSortOptions(),
        ] );
    }

    /**
     * Store a newly created menu.
     */
    public function store( StoreMenuRequest $request ): RedirectResponse
    {
        $data               = $request->validated();
        $data['created_by'] = auth()->id();
        $parentId           = $data['parent_id'] ?? null;

        // Shift sibling menus down to make room
        Menu::query()
            ->where( 'parent_id', $parentId )
            ->where( 'sort', '>=', $data['sort'] )
            ->increment( 'sort' );

        $menu = Menu::create( $data );

        // If no parent selected, it's a new type menu — sync to Data Reference
        if ( empty( $data['parent_id'] ) ) {
            $this->syncMenuToDataReference( $menu );
        }

        return redirect()
            ->route( 'portal-administration.menus.index' )
            ->with( 'status', 'menu-created' );
    }

    /**
     * Display the specified menu.
     */
    public function show( Menu $menu ): View
    {
        $menu->load( 'parent' );

        return view( 'portaladministration::menus.show', compact( 'menu' ) );
    }

    /**
     * Show the form for editing the specified menu.
     */
    public function edit( Menu $menu ): View
    {
        return view( 'portaladministration::menus.edit', [
            'menu'          => $menu,
            'parentOptions' => $this->getParentOptions( $menu->id ),
            'sortOptions'   => $this->buildSortOptions( $menu->id, $menu->parent_id ),
        ] );
    }

    /**
     * Update the specified menu.
     */
    public function update( UpdateMenuRequest $request, Menu $menu ): RedirectResponse
    {
        $data               = $request->validated();
        $data['updated_by'] = auth()->id();

        $oldSort  = $menu->sort;
        $newSort  = (int) $data['sort'];
        $parentId = $data['parent_id'] ?? $menu->parent_id;

        if ( $oldSort !== $newSort ) {
            if ( $newSort < $oldSort ) {
                Menu::query()
                    ->where( 'parent_id', $parentId )
                    ->where( 'id', '!=', $menu->id )
                    ->where( 'sort', '>=', $newSort )
                    ->where( 'sort', '<', $oldSort )
                    ->increment( 'sort' );
            } else {
                Menu::query()
                    ->where( 'parent_id', $parentId )
                    ->where( 'id', '!=', $menu->id )
                    ->where( 'sort', '>', $oldSort )
                    ->where( 'sort', '<=', $newSort )
                    ->decrement( 'sort' );
            }
        }

        $menu->update( $data );

        // If parent menu (type menu), sync to Data Reference
        if ( ! $menu->parent_id ) {
            $this->syncMenuToDataReference( $menu );
        }

        return redirect()
            ->route( 'portal-administration.menus.index' )
            ->with( 'status', 'menu-updated' );
    }

    /**
     * Soft-delete the specified menu.
     */
    public function destroy( Menu $menu ): RedirectResponse
    {
        $deletedSort = $menu->sort;

        $menu->update( ['deleted_by' => auth()->id()] );
        $menu->delete();

        // Reorder remaining sibling menus
        Menu::query()
            ->where( 'parent_id', $menu->parent_id )
            ->where( 'sort', '>', $deletedSort )
            ->decrement( 'sort' );

        // If parent menu, also soft-delete matching Data Reference
        if ( ! $menu->parent_id && $menu->type_id ) {
            $ref = DataReference::find( $menu->type_id );

            if ( $ref ) {
                $ref->update( ['deleted_by' => auth()->id()] );
                $ref->delete();
            }
        }

        return redirect()
            ->route( 'portal-administration.menus.index' )
            ->with( 'status', 'menu-deleted' );
    }

    /**
     * Restore a soft-deleted menu.
     */
    public function restore( int $id ): RedirectResponse
    {
        $menu = Menu::withTrashed()->findOrFail( $id );
        $menu->restore();
        $menu->update( ['deleted_by' => null] );

        return redirect()
            ->route( 'portal-administration.menus.index' )
            ->with( 'status', 'menu-restored' );
    }

    /**
     * Permanently delete a menu.
     */
    public function forceDelete( int $id ): RedirectResponse
    {
        $menu = Menu::withTrashed()->findOrFail( $id );
        $menu->forceDelete();

        return redirect()
            ->route( 'portal-administration.menus.index' )
            ->with( 'status', 'menu-deleted' );
    }

    /**
     * Toggle status of a menu.
     */
    public function toggleStatus( Menu $menu ): RedirectResponse
    {
        $newStatus = $menu->status_id ? 0 : 1;

        $menu->update( [
            'status_id'  => $newStatus,
            'updated_by' => auth()->id(),
        ] );

        // If parent menu, cascade to children and sync to Data Reference
        if ( ! $menu->parent_id ) {
            Menu::query()
                ->where( 'parent_id', $menu->id )
                ->update( [
                    'status_id'  => $newStatus,
                    'updated_by' => auth()->id(),
                ] );

            if ( $menu->type_id ) {
                DataReference::where( 'id', $menu->type_id )->update( [
                    'status'     => $newStatus,
                    'updated_by' => auth()->id(),
                ] );
            }
        }

        return redirect()
            ->back()
            ->with( 'status', 'menu-updated' );
    }

    /**
     * Update sort order of a menu (scoped to siblings).
     */
    public function updateSort( Request $request, Menu $menu ): JsonResponse
    {
        $direction = $request->input( 'direction' );

        if ( ! in_array( $direction, ['up', 'down'], true ) ) {
            return response()->json( ['success' => false, 'message' => 'Invalid direction'], 400 );
        }

        $currentSort = $menu->sort;

        $query = Menu::query()->where( 'parent_id', $menu->parent_id );

        if ( $direction === 'up' ) {
            $swap = $query
                ->where( 'sort', '<', $currentSort )
                ->orderBy( 'sort', 'desc' )
                ->first();
        } else {
            $swap = $query
                ->where( 'sort', '>', $currentSort )
                ->orderBy( 'sort', 'asc' )
                ->first();
        }

        if ( ! $swap ) {
            return response()->json( ['success' => false, 'message' => 'Cannot move further'], 400 );
        }

        $swapSort = $swap->sort;
        $menu->update( ['sort' => $swapSort, 'updated_by' => auth()->id()] );
        $swap->update( ['sort' => $currentSort, 'updated_by' => auth()->id()] );

        return response()->json( ['success' => true] );
    }

    /**
     * API: get sort options by parent.
     */
    public function sortOptionsApi( ?int $parentId = null ): JsonResponse
    {
        return response()->json( $this->buildSortOptions( null, $parentId ?: null ) );
    }

    /**
     * Sync a parent menu to its corresponding Data Reference.
     */
    private function syncMenuToDataReference( Menu $menu ): void
    {
        $jenisMenu = DataReference::query()
            ->whereNull( 'parent_id' )
            ->where( 'label_my', 'Jenis Menu' )
            ->first();

        if ( ! $jenisMenu ) {
            return;
        }

        if ( $menu->type_id ) {
            // Update existing Data Reference
            DataReference::where( 'id', $menu->type_id )->update( [
                'label_my'   => $menu->title_my,
                'label_en'   => $menu->title_en,
                'status'     => $menu->status_id,
                'updated_by' => auth()->id(),
            ] );
        } else {
            // Create new Data Reference child
            $nextSort = (int) DataReference::query()
                ->where( 'parent_id', $jenisMenu->id )
                ->max( 'sort' ) + 1;

            $ref = DataReference::create( [
                'parent_id'  => $jenisMenu->id,
                'label_my'   => $menu->title_my,
                'label_en'   => $menu->title_en,
                'status'     => $menu->status_id,
                'sort'       => $nextSort,
                'created_by' => auth()->id(),
            ] );

            $menu->update( ['type_id' => $ref->id] );
        }
    }

    /**
     * @return array<int, string>
     */
    private function getParentOptions( ?int $excludeId = null ): array
    {
        $parents = Menu::query()
            ->whereNull( 'parent_id' )
            ->when( $excludeId, fn ( $q ) => $q->where( 'id', '!=', $excludeId ) )
            ->with( ['children' => fn ( $q ) => $q->when( $excludeId, fn ( $q2 ) => $q2->where( 'id', '!=', $excludeId ) )->ordered()] )
            ->ordered()
            ->get();

        $options = [];

        foreach ( $parents as $parent ) {
            $options[$parent->id] = $parent->title_my ?? $parent->title_en ?? '—';

            foreach ( $parent->children as $child ) {
                $options[$child->id] = '↳ ' . ( $child->title_my ?? $child->title_en ?? '—' );
            }
        }

        return $options;
    }

    /**
     * Build sort position options for dropdown (scoped to siblings).
     */
    private function buildSortOptions( ?int $excludeId = null, ?int $parentId = null ): array
    {
        $items = Menu::query()
            ->whereNull( 'deleted_at' )
            ->where( 'parent_id', $parentId )
            ->when( $excludeId, fn ( $q ) => $q->where( 'id', '!=', $excludeId ) )
            ->orderBy( 'sort', 'asc' )
            ->get( ['id', 'title_en', 'title_my', 'sort'] );

        $options  = [];
        $position = 1;

        $options[$position] = __( 'modules/portal-administration/menu.sort_options.first' );
        $position++;

        foreach ( $items as $item ) {
            $options[$position] = __( 'modules/portal-administration/menu.sort_options.after', [
                'position' => $this->ordinal( $position ),
                'name'     => $item->title_my ?? $item->title_en,
            ] );
            $position++;
        }

        return $options;
    }

    /**
     * Convert number to ordinal (1st, 2nd, 3rd, etc.).
     */
    private function ordinal( int $number ): string
    {
        $suffix = ['th', 'st', 'nd', 'rd', 'th', 'th', 'th', 'th', 'th', 'th'];

        if ( ( $number % 100 ) >= 11 && ( $number % 100 ) <= 13 ) {
            return $number . 'th';
        }

        return $number . $suffix[$number % 10];
    }
}
