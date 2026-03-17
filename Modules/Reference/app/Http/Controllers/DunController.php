<?php

declare(strict_types=1);

namespace Modules\Reference\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Modules\Reference\Models\Dun;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Modules\Reference\Models\Parliament;
use Modules\Reference\DataTables\DunDataTable;
use Modules\Reference\Http\Requests\StoreDunRequest;
use Modules\Reference\Http\Requests\UpdateDunRequest;

class DunController extends Controller
{
    public function __construct(
        protected DunDataTable $dunDataTable,
    ) {}

    /**
     * Display a listing of DUNs.
     */
    public function index( Request $request ): JsonResponse|View
    {
        if ( $request->ajax() ) {
            return $this->dunDataTable->ajax();
        }

        return view( 'reference::duns.index', [
            'dataTable' => $this->dunDataTable,
        ] );
    }

    /**
     * Show the form for creating a new DUN.
     */
    public function create(): View
    {
        return view( 'reference::duns.create', [
            'parliamentOptions' => $this->getParliamentOptions(),
            'sortOptions'       => $this->buildSortOptions(),
        ] );
    }

    /**
     * Store a newly created DUN.
     */
    public function store( StoreDunRequest $request ): RedirectResponse
    {
        $data               = $request->validated();
        $data['created_by'] = auth()->id();

        // Shift existing DUNs down to make room
        Dun::query()
            ->where( 'sort', '>=', $data['sort'] )
            ->increment( 'sort' );

        $dun = Dun::create( $data );

        return redirect()
            ->route( 'reference.duns.index' )
            ->with( 'status', 'dun-created' );
    }

    /**
     * Display the specified DUN.
     */
    public function show( Dun $dun ): View
    {
        $dun->load( 'parliament.state' );

        return view( 'reference::duns.show', compact( 'dun' ) );
    }

    /**
     * Show the form for editing the specified DUN.
     */
    public function edit( Dun $dun ): View
    {
        return view( 'reference::duns.edit', [
            'dun'               => $dun,
            'parliamentOptions' => $this->getParliamentOptions(),
            'sortOptions'       => $this->buildSortOptions( $dun->id ),
        ] );
    }

    /**
     * Update the specified DUN.
     */
    public function update( UpdateDunRequest $request, Dun $dun ): RedirectResponse
    {
        $data               = $request->validated();
        $data['updated_by'] = auth()->id();

        $oldSort = $dun->sort;
        $newSort = (int) $data['sort'];

        if ( $oldSort !== $newSort ) {
            if ( $newSort < $oldSort ) {
                // Moving up: shift others down
                Dun::query()
                    ->where( 'id', '!=', $dun->id )
                    ->where( 'sort', '>=', $newSort )
                    ->where( 'sort', '<', $oldSort )
                    ->increment( 'sort' );
            } else {
                // Moving down: shift others up
                Dun::query()
                    ->where( 'id', '!=', $dun->id )
                    ->where( 'sort', '>', $oldSort )
                    ->where( 'sort', '<=', $newSort )
                    ->decrement( 'sort' );
            }
        }

        $dun->update( $data );

        return redirect()
            ->route( 'reference.duns.index' )
            ->with( 'status', 'dun-updated' );
    }

    /**
     * Soft-delete the specified DUN.
     */
    public function destroy( Dun $dun ): RedirectResponse
    {
        $dun->update( ['deleted_by' => auth()->id()] );
        $dun->delete();

        return redirect()
            ->route( 'reference.duns.index' )
            ->with( 'status', 'dun-deleted' );
    }

    /**
     * Restore a soft-deleted DUN.
     */
    public function restore( int $id ): RedirectResponse
    {
        $dun = Dun::withTrashed()->findOrFail( $id );
        $dun->restore();
        $dun->update( ['deleted_by' => null] );

        return redirect()
            ->route( 'reference.duns.index' )
            ->with( 'status', 'dun-restored' );
    }

    /**
     * Permanently delete a DUN.
     */
    public function forceDelete( int $id ): RedirectResponse
    {
        $dun = Dun::withTrashed()->findOrFail( $id );
        $dun->forceDelete();

        return redirect()
            ->route( 'reference.duns.index' )
            ->with( 'status', 'dun-deleted' );
    }

    /**
     * Update sort order of a DUN.
     */
    public function updateSort( Request $request, Dun $dun ): JsonResponse
    {
        $direction = $request->input( 'direction' );

        if ( ! in_array( $direction, ['up', 'down'], true ) ) {
            return response()->json( ['success' => false, 'message' => 'Invalid direction'], 400 );
        }

        $currentSort = $dun->sort;

        if ( $direction === 'up' ) {
            $swapDun = Dun::query()
                ->where( 'sort', '<', $currentSort )
                ->orderBy( 'sort', 'desc' )
                ->first();
        } else {
            $swapDun = Dun::query()
                ->where( 'sort', '>', $currentSort )
                ->orderBy( 'sort', 'asc' )
                ->first();
        }

        if ( ! $swapDun ) {
            return response()->json( ['success' => false, 'message' => 'Cannot move further'], 400 );
        }

        $swapSort = $swapDun->sort;
        $dun->update( ['sort' => $swapSort, 'updated_by' => auth()->id()] );
        $swapDun->update( ['sort' => $currentSort, 'updated_by' => auth()->id()] );

        return response()->json( ['success' => true] );
    }

    /**
     * @return array<string, string>
     */
    private function getParliamentOptions(): array
    {
        return Parliament::query()
            ->ordered()
            ->pluck( 'name', 'id' )
            ->all();
    }

    /**
     * Build sort position options for dropdown.
     */
    private function buildSortOptions( ?int $excludeId = null ): array
    {
        $duns = Dun::query()
            ->whereNull( 'deleted_at' )
            ->when( $excludeId, fn ( $q ) => $q->where( 'id', '!=', $excludeId ) )
            ->orderBy( 'sort', 'asc' )
            ->get( ['id', 'name', 'sort'] );

        $options  = [];
        $position = 1;

        // First position option
        $options[$position] = __( 'modules/reference/dun.sort_options.first' );
        $position++;

        // After each existing DUN
        foreach ( $duns as $dun ) {
            $options[$position] = __( 'modules/reference/dun.sort_options.after', [
                'position' => $this->ordinal( $position ),
                'name'     => $dun->name,
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
