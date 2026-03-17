<?php

declare(strict_types=1);

namespace Modules\Reference\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Modules\Reference\Models\Menu;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Modules\Reference\DataTables\MenuDataTable;
use Modules\Reference\Http\Requests\StoreMenuRequest;
use Modules\Reference\Http\Requests\UpdateMenuRequest;

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

        return view( 'reference::menus.index', [
            'dataTable' => $this->menuDataTable,
        ] );
    }

    /**
     * Show the form for creating a new menu.
     */
    public function create(): View
    {
        return view( 'reference::menus.create', [
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

        // Shift existing menus down to make room
        Menu::query()
            ->where( 'sort', '>=', $data['sort'] )
            ->increment( 'sort' );

        Menu::create( $data );

        return redirect()
            ->route( 'reference.menus.index' )
            ->with( 'status', 'menu-created' );
    }

    /**
     * Display the specified menu.
     */
    public function show( Menu $menu ): View
    {
        $menu->load( 'parent' );

        return view( 'reference::menus.show', compact( 'menu' ) );
    }

    /**
     * Show the form for editing the specified menu.
     */
    public function edit( Menu $menu ): View
    {
        return view( 'reference::menus.edit', [
            'menu'          => $menu,
            'parentOptions' => $this->getParentOptions( $menu->id ),
            'sortOptions'   => $this->buildSortOptions( $menu->id ),
        ] );
    }

    /**
     * Update the specified menu.
     */
    public function update( UpdateMenuRequest $request, Menu $menu ): RedirectResponse
    {
        $data               = $request->validated();
        $data['updated_by'] = auth()->id();

        $oldSort = $menu->sort;
        $newSort = (int) $data['sort'];

        if ( $oldSort !== $newSort ) {
            if ( $newSort < $oldSort ) {
                Menu::query()
                    ->where( 'id', '!=', $menu->id )
                    ->where( 'sort', '>=', $newSort )
                    ->where( 'sort', '<', $oldSort )
                    ->increment( 'sort' );
            } else {
                Menu::query()
                    ->where( 'id', '!=', $menu->id )
                    ->where( 'sort', '>', $oldSort )
                    ->where( 'sort', '<=', $newSort )
                    ->decrement( 'sort' );
            }
        }

        $menu->update( $data );

        return redirect()
            ->route( 'reference.menus.index' )
            ->with( 'status', 'menu-updated' );
    }

    /**
     * Soft-delete the specified menu.
     */
    public function destroy( Menu $menu ): RedirectResponse
    {
        $menu->update( ['deleted_by' => auth()->id()] );
        $menu->delete();

        return redirect()
            ->route( 'reference.menus.index' )
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
            ->route( 'reference.menus.index' )
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
            ->route( 'reference.menus.index' )
            ->with( 'status', 'menu-deleted' );
    }

    /**
     * Update sort order of a menu.
     */
    public function updateSort( Request $request, Menu $menu ): JsonResponse
    {
        $direction = $request->input( 'direction' );

        if ( ! in_array( $direction, ['up', 'down'], true ) ) {
            return response()->json( ['success' => false, 'message' => 'Invalid direction'], 400 );
        }

        $currentSort = $menu->sort;

        if ( $direction === 'up' ) {
            $swap = Menu::query()
                ->where( 'sort', '<', $currentSort )
                ->orderBy( 'sort', 'desc' )
                ->first();
        } else {
            $swap = Menu::query()
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
     * @return array<int, string>
     */
    private function getParentOptions( ?int $excludeId = null ): array
    {
        return Menu::query()
            ->when( $excludeId, fn ( $q ) => $q->where( 'id', '!=', $excludeId ) )
            ->ordered()
            ->pluck( 'title_en', 'id' )
            ->all();
    }

    /**
     * Build sort position options for dropdown.
     */
    private function buildSortOptions( ?int $excludeId = null ): array
    {
        $items = Menu::query()
            ->whereNull( 'deleted_at' )
            ->when( $excludeId, fn ( $q ) => $q->where( 'id', '!=', $excludeId ) )
            ->orderBy( 'sort', 'asc' )
            ->get( ['id', 'title_en', 'sort'] );

        $options  = [];
        $position = 1;

        $options[$position] = __( 'modules/reference/menu.sort_options.first' );
        $position++;

        foreach ( $items as $item ) {
            $options[$position] = __( 'modules/reference/menu.sort_options.after', [
                'position' => $this->ordinal( $position ),
                'name'     => $item->title_en,
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
