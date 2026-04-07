<?php

declare(strict_types=1);

namespace Modules\Reference\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Modules\Reference\Models\State;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Modules\Reference\Models\Parliament;
use Modules\Reference\DataTables\ParliamentDataTable;
use Modules\Reference\Http\Requests\StoreParliamentRequest;
use Modules\Reference\Http\Requests\UpdateParliamentRequest;

class ParliamentController extends Controller
{
    public function __construct(
        protected ParliamentDataTable $parliamentDataTable,
    ) {}

    /**
     * Display a listing of parliaments.
     */
    public function index( Request $request ): View
    {
        $stateId = $request->integer( 'state_id' ) ?: null;

        $this->parliamentDataTable->setStateId( $stateId );

        $state = $stateId ? State::find( $stateId ) : null;

        return view( 'reference::parliaments.index', [
            'dataTable' => $this->parliamentDataTable,
            'state'     => $state,
        ] );
    }

    public function data( Request $request ): JsonResponse
    {
        $stateId = $request->integer( 'state_id' ) ?: null;

        $this->parliamentDataTable->setStateId( $stateId );

        return $this->parliamentDataTable->ajax();
    }

    /**
     * Show the form for creating a new parliament.
     */
    public function create(): View
    {
        return view( 'reference::parliaments.create', [
            'stateOptions' => $this->getStateOptions(),
            'sortOptions'  => $this->buildSortOptions(),
        ] );
    }

    /**
     * Store a newly created parliament.
     */
    public function store( StoreParliamentRequest $request ): RedirectResponse
    {
        $data               = $request->validated();
        $data['created_by'] = auth()->id();

        // Shift existing parliaments down to make room
        Parliament::query()
            ->where( 'sort', '>=', $data['sort'] )
            ->increment( 'sort' );

        $parliament = Parliament::create( $data );

        return redirect()
            ->route( 'reference.parliaments.index' )
            ->with( 'status', 'parliament-created' );
    }

    /**
     * Display the specified parliament.
     */
    public function show( Parliament $parliament ): View
    {
        $parliament->load( 'state' );

        return view( 'reference::parliaments.show', compact( 'parliament' ) );
    }

    /**
     * Show the form for editing the specified parliament.
     */
    public function edit( Parliament $parliament ): View
    {
        return view( 'reference::parliaments.edit', [
            'parliament'   => $parliament,
            'stateOptions' => $this->getStateOptions(),
            'sortOptions'  => $this->buildSortOptions( $parliament->id ),
        ] );
    }

    /**
     * Update the specified parliament.
     */
    public function update( UpdateParliamentRequest $request, Parliament $parliament ): RedirectResponse
    {
        $data               = $request->validated();
        $data['updated_by'] = auth()->id();

        $oldSort = $parliament->sort;
        $newSort = (int) $data['sort'];

        if ( $oldSort !== $newSort ) {
            if ( $newSort < $oldSort ) {
                // Moving up: shift others down
                Parliament::query()
                    ->where( 'id', '!=', $parliament->id )
                    ->where( 'sort', '>=', $newSort )
                    ->where( 'sort', '<', $oldSort )
                    ->increment( 'sort' );
            } else {
                // Moving down: shift others up
                Parliament::query()
                    ->where( 'id', '!=', $parliament->id )
                    ->where( 'sort', '>', $oldSort )
                    ->where( 'sort', '<=', $newSort )
                    ->decrement( 'sort' );
            }
        }

        $parliament->update( $data );

        return redirect()
            ->route( 'reference.parliaments.index' )
            ->with( 'status', 'parliament-updated' );
    }

    /**
     * Soft-delete the specified parliament.
     */
    public function destroy( Parliament $parliament ): RedirectResponse
    {
        $parliament->update( ['deleted_by' => auth()->id()] );
        $parliament->delete();

        return redirect()
            ->route( 'reference.parliaments.index' )
            ->with( 'status', 'parliament-deleted' );
    }

    /**
     * Restore a soft-deleted parliament.
     */
    public function restore( int $id ): RedirectResponse
    {
        $parliament = Parliament::withTrashed()->findOrFail( $id );
        $parliament->restore();
        $parliament->update( ['deleted_by' => null] );

        return redirect()
            ->route( 'reference.parliaments.index' )
            ->with( 'status', 'parliament-restored' );
    }

    /**
     * Permanently delete a parliament.
     */
    public function forceDelete( int $id ): RedirectResponse
    {
        $parliament = Parliament::withTrashed()->findOrFail( $id );
        $parliament->forceDelete();

        return redirect()
            ->route( 'reference.parliaments.index' )
            ->with( 'status', 'parliament-deleted' );
    }

    /**
     * Toggle status of a parliament and cascade to DUNs.
     */
    public function toggleStatus( Parliament $parliament ): RedirectResponse
    {
        $newStatus = ! $parliament->status;

        $parliament->update( [
            'status'     => $newStatus,
            'updated_by' => auth()->id(),
        ] );

        $parliament->duns()->update( [
            'status'     => $newStatus,
            'updated_by' => auth()->id(),
        ] );

        return redirect()
            ->back()
            ->with( 'status', 'parliament-updated' );
    }

    /**
     * @return array<string, string>
     */
    private function getStateOptions(): array
    {
        return State::query()
            ->ordered()
            ->pluck( 'name', 'id' )
            ->all();
    }

    public function updateSort( Request $request, Parliament $parliament ): JsonResponse
    {
        $direction = $request->input( 'direction' );

        if ( ! in_array( $direction, ['up', 'down'], true ) ) {
            return response()->json( ['success' => false, 'message' => 'Invalid direction'], 400 );
        }

        $currentSort = $parliament->sort;

        if ( $direction === 'up' ) {
            $swapParliament = Parliament::query()
                ->where( 'sort', '<', $currentSort )
                ->orderBy( 'sort', 'desc' )
                ->first();
        } else {
            $swapParliament = Parliament::query()
                ->where( 'sort', '>', $currentSort )
                ->orderBy( 'sort', 'asc' )
                ->first();
        }

        if ( ! $swapParliament ) {
            return response()->json( ['success' => false, 'message' => 'Cannot move further'], 400 );
        }

        $swapSort = $swapParliament->sort;
        $parliament->update( ['sort' => $swapSort, 'updated_by' => auth()->id()] );
        $swapParliament->update( ['sort' => $currentSort, 'updated_by' => auth()->id()] );

        return response()->json( ['success' => true] );
    }

    /**
     * Build sort position options for dropdown.
     */
    private function buildSortOptions( ?int $excludeId = null ): array
    {
        $parliaments = Parliament::query()
            ->whereNull( 'deleted_at' )
            ->when( $excludeId, fn ( $q ) => $q->where( 'id', '!=', $excludeId ) )
            ->orderBy( 'sort', 'asc' )
            ->get( ['id', 'name', 'sort'] );

        $options  = [];
        $position = 1;

        // First position option
        $options[$position] = __( 'modules/reference/parliament.sort_options.first' );
        $position++;

        // After each existing parliament
        foreach ( $parliaments as $parliament ) {
            $options[$position] = __( 'modules/reference/parliament.sort_options.after', [
                'position' => $this->ordinal( $position ),
                'name'     => $parliament->name,
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
