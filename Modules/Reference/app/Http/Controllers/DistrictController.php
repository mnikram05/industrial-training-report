<?php

declare(strict_types=1);

namespace Modules\Reference\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Modules\Reference\Models\State;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Modules\Reference\Models\District;
use Modules\Reference\DataTables\DistrictDataTable;
use Modules\Reference\Http\Requests\StoreDistrictRequest;
use Modules\Reference\Http\Requests\UpdateDistrictRequest;

class DistrictController extends Controller
{
    public function __construct(
        protected DistrictDataTable $districtDataTable,
    ) {}

    /**
     * Display a listing of districts.
     */
    public function index( Request $request ): JsonResponse|View
    {
        if ( $request->ajax() ) {
            return $this->districtDataTable->ajax();
        }

        return view( 'modules.districts.index', [
            'dataTable' => $this->districtDataTable,
        ] );
    }

    /**
     * Show the form for creating a new district.
     */
    public function create(): View
    {
        return view( 'modules.districts.create', [
            'stateOptions' => $this->getStateOptions(),
        ] );
    }

    /**
     * Store a newly created district.
     */
    public function store( StoreDistrictRequest $request ): RedirectResponse
    {
        $data               = $request->validated();
        $data['created_by'] = auth()->id();

        $district = District::create( $data );

        return redirect()
            ->route( 'reference.districts.edit', $district )
            ->with( 'status', 'district-created' );
    }

    /**
     * Display the specified district.
     */
    public function show( District $district ): View
    {
        $district->load( 'state' );

        return view( 'modules.districts.show', compact( 'district' ) );
    }

    /**
     * Show the form for editing the specified district.
     */
    public function edit( District $district ): View
    {
        return view( 'modules.districts.edit', [
            'district'     => $district,
            'stateOptions' => $this->getStateOptions(),
        ] );
    }

    /**
     * Update the specified district.
     */
    public function update( UpdateDistrictRequest $request, District $district ): RedirectResponse
    {
        $data               = $request->validated();
        $data['updated_by'] = auth()->id();

        $district->update( $data );

        return redirect()
            ->route( 'reference.districts.edit', $district )
            ->with( 'status', 'district-updated' );
    }

    /**
     * Soft-delete the specified district.
     */
    public function destroy( District $district ): RedirectResponse
    {
        $district->update( ['deleted_by' => auth()->id()] );
        $district->delete();

        return redirect()
            ->route( 'reference.districts.index' )
            ->with( 'status', 'district-deleted' );
    }

    /**
     * Restore a soft-deleted district.
     */
    public function restore( int $id ): RedirectResponse
    {
        $district = District::withTrashed()->findOrFail( $id );
        $district->restore();
        $district->update( ['deleted_by' => null] );

        return redirect()
            ->route( 'reference.districts.index' )
            ->with( 'status', 'district-restored' );
    }

    /**
     * Permanently delete a district.
     */
    public function forceDelete( int $id ): RedirectResponse
    {
        $district = District::withTrashed()->findOrFail( $id );
        $district->forceDelete();

        return redirect()
            ->route( 'reference.districts.index' )
            ->with( 'status', 'district-deleted' );
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
