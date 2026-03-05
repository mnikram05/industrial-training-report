<?php

declare(strict_types=1);

namespace Modules\Reference\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Modules\Reference\Models\State;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Modules\Reference\DataTables\StateDataTable;
use Modules\Reference\Http\Requests\StoreStateRequest;
use Modules\Reference\Http\Requests\UpdateStateRequest;

class StateController extends Controller
{
    public function __construct(
        protected StateDataTable $stateDataTable,
    ) {}

    /**
     * Display a listing of states.
     */
    public function index( Request $request ): JsonResponse|View
    {
        if ( $request->ajax() ) {
            return $this->stateDataTable->ajax();
        }

        return view( 'reference::states.index', [
            'dataTable' => $this->stateDataTable,
        ] );
    }

    /**
     * Show the form for creating a new state.
     */
    public function create(): View
    {
        $sortOptions = $this->buildSortOptions();

        return view( 'reference::states.create', compact( 'sortOptions' ) );
    }

    /**
     * Store a newly created state.
     */
    public function store( StoreStateRequest $request ): RedirectResponse
    {
        $data               = $request->validated();
        $data['created_by'] = auth()->id();

        $state = State::create( $data );

        return redirect()
            ->route( 'reference.states.index' )
            ->with( 'status', 'state-created' );
    }

    /**
     * Display the specified state.
     */
    public function show( State $state ): View
    {
        return view( 'reference::states.show', compact( 'state' ) );
    }

    /**
     * Show the form for editing the specified state.
     */
    public function edit( State $state ): View
    {
        $sortOptions = $this->buildSortOptions( $state->id );

        return view( 'reference::states.edit', compact( 'state', 'sortOptions' ) );
    }

    /**
     * Update the specified state.
     */
    public function update( UpdateStateRequest $request, State $state ): RedirectResponse
    {
        $data               = $request->validated();
        $data['updated_by'] = auth()->id();

        $state->update( $data );

        return redirect()
            ->route( 'reference.states.index' )
            ->with( 'status', 'state-updated' );
    }

    /**
     * Soft-delete the specified state.
     */
    public function destroy( State $state ): RedirectResponse
    {
        $state->update( ['deleted_by' => auth()->id()] );
        $state->delete();

        return redirect()
            ->route( 'reference.states.index' )
            ->with( 'status', 'state-deleted' );
    }

    /**
     * Restore a soft-deleted state.
     */
    public function restore( int $id ): RedirectResponse
    {
        $state = State::withTrashed()->findOrFail( $id );
        $state->restore();
        $state->update( ['deleted_by' => null] );

        return redirect()
            ->route( 'reference.states.index' )
            ->with( 'status', 'state-restored' );
    }

    /**
     * Permanently delete a state.
     */
    public function forceDelete( int $id ): RedirectResponse
    {
        $state = State::withTrashed()->findOrFail( $id );
        $state->forceDelete();

        return redirect()
            ->route( 'reference.states.index' )
            ->with( 'status', 'state-deleted' );
    }

    /**
     * Toggle status of a state.
     */
    public function toggleStatus( State $state ): RedirectResponse
    {
        $state->update( [
            'status'     => ! $state->status,
            'updated_by' => auth()->id(),
        ] );

        return redirect()
            ->back()
            ->with( 'status', 'state-updated' );
    }

    /**
     * Update sort order of a state.
     */
    public function updateSort( Request $request, State $state ): JsonResponse
    {
        $direction = $request->input( 'direction' );

        if ( ! in_array( $direction, ['up', 'down'], true ) ) {
            return response()->json( ['success' => false, 'message' => 'Invalid direction'], 400 );
        }

        $currentSort = $state->sort;

        if ( $direction === 'up' ) {
            $swapState = State::query()
                ->where( 'sort', '<', $currentSort )
                ->orderBy( 'sort', 'desc' )
                ->first();
        } else {
            $swapState = State::query()
                ->where( 'sort', '>', $currentSort )
                ->orderBy( 'sort', 'asc' )
                ->first();
        }

        if ( ! $swapState ) {
            return response()->json( ['success' => false, 'message' => 'Cannot move further'], 400 );
        }

        $swapSort = $swapState->sort;
        $state->update( ['sort' => $swapSort, 'updated_by' => auth()->id()] );
        $swapState->update( ['sort' => $currentSort, 'updated_by' => auth()->id()] );

        return response()->json( ['success' => true] );
    }

    /**
     * Build sort position options for dropdown.
     */
    private function buildSortOptions( ?int $excludeId = null ): array
    {
        $states = State::query()
            ->whereNull( 'deleted_at' )
            ->when( $excludeId, fn ( $q ) => $q->where( 'id', '!=', $excludeId ) )
            ->orderBy( 'sort', 'asc' )
            ->get( ['id', 'name', 'sort'] );

        $options  = [];
        $position = 1;

        // First position option
        $options[$position] = __( '1st - First' );
        $position++;

        // After each existing state
        foreach ( $states as $state ) {
            $options[$position] = __( ':position - After :name', [
                'position' => $this->ordinal( $position ),
                'name'     => $state->name,
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
