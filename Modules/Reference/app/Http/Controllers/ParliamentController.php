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
    public function index( Request $request ): JsonResponse|View
    {
        if ( $request->ajax() ) {
            return $this->parliamentDataTable->ajax();
        }

        return view( 'modules.parliaments.index', [
            'dataTable' => $this->parliamentDataTable,
        ] );
    }

    /**
     * Show the form for creating a new parliament.
     */
    public function create(): View
    {
        return view( 'modules.parliaments.create', [
            'stateOptions' => $this->getStateOptions(),
        ] );
    }

    /**
     * Store a newly created parliament.
     */
    public function store( StoreParliamentRequest $request ): RedirectResponse
    {
        $data               = $request->validated();
        $data['created_by'] = auth()->id();

        $parliament = Parliament::create( $data );

        return redirect()
            ->route( 'reference.parliaments.edit', $parliament )
            ->with( 'status', 'parliament-created' );
    }

    /**
     * Display the specified parliament.
     */
    public function show( Parliament $parliament ): View
    {
        $parliament->load( 'state' );

        return view( 'modules.parliaments.show', compact( 'parliament' ) );
    }

    /**
     * Show the form for editing the specified parliament.
     */
    public function edit( Parliament $parliament ): View
    {
        return view( 'modules.parliaments.edit', [
            'parliament'   => $parliament,
            'stateOptions' => $this->getStateOptions(),
        ] );
    }

    /**
     * Update the specified parliament.
     */
    public function update( UpdateParliamentRequest $request, Parliament $parliament ): RedirectResponse
    {
        $data               = $request->validated();
        $data['updated_by'] = auth()->id();

        $parliament->update( $data );

        return redirect()
            ->route( 'reference.parliaments.edit', $parliament )
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
     * @return array<string, string>
     */
    private function getStateOptions(): array
    {
        return State::query()
            ->ordered()
            ->pluck( 'name', 'id' )
            ->all();
    }
}
