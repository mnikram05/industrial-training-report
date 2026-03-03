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

        return view( 'modules.states.index', [
            'dataTable' => $this->stateDataTable,
        ] );
    }

    /**
     * Show the form for creating a new state.
     */
    public function create(): View
    {
        return view( 'modules::reference.states.create' );
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
        return view( 'modules.states.show', compact( 'state' ) );
    }

    /**
     * Show the form for editing the specified state.
     */
    public function edit( State $state ): View
    {
        return view( 'modules.states.edit', compact( 'state' ) );
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
            ->route( 'reference.states.edit', $state )
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
}
