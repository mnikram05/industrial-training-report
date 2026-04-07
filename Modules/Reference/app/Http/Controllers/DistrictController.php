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
    public function index( Request $request ): View
    {
        $stateId = $request->integer( 'state_id' ) ?: null;

        $this->districtDataTable->setStateId( $stateId );

        $state = $stateId ? State::find( $stateId ) : null;

        return view( 'reference::districts.index', [
            'dataTable' => $this->districtDataTable,
            'state'     => $state,
        ] );
    }

    public function data( Request $request ): JsonResponse
    {
        $stateId = $request->integer( 'state_id' ) ?: null;

        $this->districtDataTable->setStateId( $stateId );

        return $this->districtDataTable->ajax();
    }

    /**
     * Show the form for creating a new district.
     */
    public function create(): View
    {
        return view( 'reference::districts.create', [
            'stateOptions' => $this->getStateOptions(),
            'sortOptions'  => $this->buildSortOptions(),
        ] );
    }

    /**
     * Store a newly created district.
     */
    public function store( StoreDistrictRequest $request ): RedirectResponse
    {
        $data               = $request->validated();
        $data['created_by'] = auth()->id();

        // Shift existing districts down to make room
        District::query()
            ->where( 'sort', '>=', $data['sort'] )
            ->increment( 'sort' );

        $district = District::create( $data );

        return redirect()
            ->route( 'reference.districts.index' )
            ->with( 'status', 'district-created' );
    }

    /**
     * Display the specified district.
     */
    public function show( District $district ): View
    {
        $district->load( 'state' );

        return view( 'reference::districts.show', compact( 'district' ) );
    }

    /**
     * Show the form for editing the specified district.
     */
    public function edit( District $district ): View
    {
        return view( 'reference::districts.edit', [
            'district'     => $district,
            'stateOptions' => $this->getStateOptions(),
            'sortOptions'  => $this->buildSortOptions( $district->id ),
        ] );
    }

    /**
     * Update the specified district.
     */
    public function update( UpdateDistrictRequest $request, District $district ): RedirectResponse
    {
        $data               = $request->validated();
        $data['updated_by'] = auth()->id();

        $oldSort = $district->sort;
        $newSort = (int) $data['sort'];

        if ( $oldSort !== $newSort ) {
            if ( $newSort < $oldSort ) {
                // Moving up: shift others down
                District::query()
                    ->where( 'id', '!=', $district->id )
                    ->where( 'sort', '>=', $newSort )
                    ->where( 'sort', '<', $oldSort )
                    ->increment( 'sort' );
            } else {
                // Moving down: shift others up
                District::query()
                    ->where( 'id', '!=', $district->id )
                    ->where( 'sort', '>', $oldSort )
                    ->where( 'sort', '<=', $newSort )
                    ->decrement( 'sort' );
            }
        }

        $district->update( $data );

        return redirect()
            ->route( 'reference.districts.index' )
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
     * Toggle status of a district.
     */
    public function toggleStatus( District $district ): RedirectResponse
    {
        $district->update( [
            'status'     => ! $district->status,
            'updated_by' => auth()->id(),
        ] );

        return redirect()
            ->back()
            ->with( 'status', 'district-updated' );
    }

    /**
     * Update sort order of a district.
     */
    public function updateSort( Request $request, District $district ): JsonResponse
    {
        $direction = $request->input( 'direction' );

        if ( ! in_array( $direction, ['up', 'down'], true ) ) {
            return response()->json( ['success' => false, 'message' => 'Invalid direction'], 400 );
        }

        $currentSort = $district->sort;

        if ( $direction === 'up' ) {
            $swapDistrict = District::query()
                ->where( 'sort', '<', $currentSort )
                ->orderBy( 'sort', 'desc' )
                ->first();
        } else {
            $swapDistrict = District::query()
                ->where( 'sort', '>', $currentSort )
                ->orderBy( 'sort', 'asc' )
                ->first();
        }

        if ( ! $swapDistrict ) {
            return response()->json( ['success' => false, 'message' => 'Cannot move further'], 400 );
        }

        $swapSort = $swapDistrict->sort;
        $district->update( ['sort' => $swapSort, 'updated_by' => auth()->id()] );
        $swapDistrict->update( ['sort' => $currentSort, 'updated_by' => auth()->id()] );

        return response()->json( ['success' => true] );
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

    /**
     * Build sort position options for dropdown.
     */
    private function buildSortOptions( ?int $excludeId = null ): array
    {
        $districts = District::query()
            ->whereNull( 'deleted_at' )
            ->when( $excludeId, fn ( $q ) => $q->where( 'id', '!=', $excludeId ) )
            ->orderBy( 'sort', 'asc' )
            ->get( ['id', 'name', 'sort'] );

        $options  = [];
        $position = 1;

        // First position option
        $options[$position] = __( 'modules/reference/district.sort_options.first' );
        $position++;

        // After each existing district
        foreach ( $districts as $district ) {
            $options[$position] = __( 'modules/reference/district.sort_options.after', [
                'position' => $this->ordinal( $position ),
                'name'     => $district->name,
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
