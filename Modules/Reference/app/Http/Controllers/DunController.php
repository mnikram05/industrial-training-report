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

        return view( 'modules.duns.index', [
            'dataTable' => $this->dunDataTable,
        ] );
    }

    /**
     * Show the form for creating a new DUN.
     */
    public function create(): View
    {
        return view( 'modules.duns.create', [
            'parliamentOptions' => $this->getParliamentOptions(),
        ] );
    }

    /**
     * Store a newly created DUN.
     */
    public function store( StoreDunRequest $request ): RedirectResponse
    {
        $data               = $request->validated();
        $data['created_by'] = auth()->id();

        $dun = Dun::create( $data );

        return redirect()
            ->route( 'reference.duns.edit', $dun )
            ->with( 'status', 'dun-created' );
    }

    /**
     * Display the specified DUN.
     */
    public function show( Dun $dun ): View
    {
        $dun->load( 'parliament.state' );

        return view( 'modules.duns.show', compact( 'dun' ) );
    }

    /**
     * Show the form for editing the specified DUN.
     */
    public function edit( Dun $dun ): View
    {
        return view( 'modules.duns.edit', [
            'dun'               => $dun,
            'parliamentOptions' => $this->getParliamentOptions(),
        ] );
    }

    /**
     * Update the specified DUN.
     */
    public function update( UpdateDunRequest $request, Dun $dun ): RedirectResponse
    {
        $data               = $request->validated();
        $data['updated_by'] = auth()->id();

        $dun->update( $data );

        return redirect()
            ->route( 'reference.duns.edit', $dun )
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
     * @return array<string, string>
     */
    private function getParliamentOptions(): array
    {
        return Parliament::query()
            ->ordered()
            ->pluck( 'name', 'id' )
            ->all();
    }
}
