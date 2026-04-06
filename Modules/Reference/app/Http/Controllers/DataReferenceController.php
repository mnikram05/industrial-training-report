<?php

declare(strict_types=1);

namespace Modules\Reference\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Modules\Reference\Models\DataReference;
use Modules\Reference\DataTables\DataReferenceDataTable;
use Modules\Reference\DataTables\ChildDataReferenceDataTable;
use Modules\Reference\Http\Requests\StoreDataReferenceRequest;
use Modules\Reference\Http\Requests\UpdateDataReferenceRequest;

class DataReferenceController extends Controller
{
    public function __construct(
        protected DataReferenceDataTable $dataReferenceDataTable,
        protected ChildDataReferenceDataTable $childDataReferenceDataTable,
    ) {}

    /**
     * Display a listing of data references.
     */
    public function index( Request $request ): JsonResponse|View
    {
        if ( $request->ajax() ) {
            return $this->dataReferenceDataTable->ajax();
        }

        return view( 'reference::data-references.index', [
            'dataTable' => $this->dataReferenceDataTable,
        ] );
    }

    /**
     * Show the form for creating a new data reference.
     */
    public function create(): View
    {
        return view( 'reference::data-references.create' );
    }

    /**
     * Store a newly created data reference.
     */
    public function store( StoreDataReferenceRequest $request ): RedirectResponse
    {
        $data               = $request->validated();
        $data['created_by'] = auth()->id();
        $data['status']     = 1;

        DataReference::create( $data );

        return redirect()
            ->route( 'reference.data-references.index' )
            ->with( 'status', 'data-reference-created' );
    }

    /**
     * Display the specified data reference.
     */
    public function show( DataReference $dataReference ): View
    {
        $dataReference->load( 'parent' );

        return view( 'reference::data-references.show', compact( 'dataReference' ) );
    }

    /**
     * Show the form for editing the specified data reference.
     */
    public function edit( DataReference $dataReference ): View
    {
        return view( 'reference::data-references.edit', [
            'dataReference' => $dataReference,
        ] );
    }

    /**
     * Update the specified data reference.
     */
    public function update( UpdateDataReferenceRequest $request, DataReference $dataReference ): RedirectResponse
    {
        $data               = $request->validated();
        $data['updated_by'] = auth()->id();

        $dataReference->update( $data );

        return redirect()
            ->route( 'reference.data-references.index' )
            ->with( 'status', 'data-reference-updated' );
    }

    /**
     * Soft-delete the specified data reference.
     */
    public function destroy( DataReference $dataReference ): RedirectResponse
    {
        $dataReference->update( ['deleted_by' => auth()->id()] );
        $dataReference->delete();

        return redirect()
            ->route( 'reference.data-references.index' )
            ->with( 'status', 'data-reference-deleted' );
    }

    /**
     * Restore a soft-deleted data reference.
     */
    public function restore( int $id ): RedirectResponse
    {
        $dataReference = DataReference::withTrashed()->findOrFail( $id );
        $dataReference->restore();
        $dataReference->update( ['deleted_by' => null] );

        return redirect()
            ->route( 'reference.data-references.index' )
            ->with( 'status', 'data-reference-restored' );
    }

    /**
     * Permanently delete a data reference.
     */
    public function forceDelete( int $id ): RedirectResponse
    {
        $dataReference = DataReference::withTrashed()->findOrFail( $id );
        $dataReference->forceDelete();

        return redirect()
            ->route( 'reference.data-references.index' )
            ->with( 'status', 'data-reference-deleted' );
    }

    /**
     * Toggle status of a data reference and cascade to children.
     */
    public function toggleStatus( DataReference $dataReference ): RedirectResponse
    {
        $newStatus = ! $dataReference->status;

        $dataReference->update( [
            'status'     => $newStatus,
            'updated_by' => auth()->id(),
        ] );

        $dataReference->children()->update( [
            'status'     => $newStatus,
            'updated_by' => auth()->id(),
        ] );

        return redirect()
            ->back()
            ->with( 'status', 'data-reference-updated' );
    }

    /**
     * Toggle status of a child data reference.
     */
    public function toggleChildStatus( DataReference $dataReference, DataReference $child ): RedirectResponse
    {
        $child->update( [
            'status'     => ! $child->status,
            'updated_by' => auth()->id(),
        ] );

        return redirect()
            ->back()
            ->with( 'status', 'data-reference-updated' );
    }

    /**
     * Display children of a data reference.
     */
    public function children( Request $request, DataReference $dataReference ): JsonResponse|View
    {
        $this->childDataReferenceDataTable->setParentId( $dataReference->id );

        if ( $request->ajax() ) {
            return $this->childDataReferenceDataTable->ajax();
        }

        return view( 'reference::data-references.children', [
            'dataReference' => $dataReference,
            'dataTable'     => $this->childDataReferenceDataTable,
        ] );
    }

    /**
     * Show form for creating a child data reference.
     */
    public function createChild( DataReference $dataReference ): View
    {
        return view( 'reference::data-references.create-child', [
            'dataReference' => $dataReference,
            'sortOptions'   => $this->buildChildSortOptions( $dataReference->id ),
        ] );
    }

    /**
     * Store a child data reference.
     */
    public function storeChild( StoreDataReferenceRequest $request, DataReference $dataReference ): RedirectResponse
    {
        $data               = $request->validated();
        $data['parent_id']  = $dataReference->id;
        $data['created_by'] = auth()->id();
        $data['status']     = 1;

        DataReference::query()
            ->where( 'parent_id', $dataReference->id )
            ->where( 'sort', '>=', $data['sort'] )
            ->increment( 'sort' );

        DataReference::create( $data );

        return redirect()
            ->route( 'reference.data-references.children', $dataReference )
            ->with( 'status', 'data-reference-created' );
    }

    /**
     * Update sort order of a child data reference.
     */
    public function updateChildSort( Request $request, DataReference $dataReference, DataReference $child ): JsonResponse
    {
        $direction = $request->input( 'direction' );

        if ( ! in_array( $direction, ['up', 'down'], true ) ) {
            return response()->json( ['success' => false, 'message' => 'Invalid direction'], 400 );
        }

        $currentSort = $child->sort;

        if ( $direction === 'up' ) {
            $swap = DataReference::query()
                ->where( 'parent_id', $dataReference->id )
                ->where( 'sort', '<', $currentSort )
                ->orderBy( 'sort', 'desc' )
                ->first();
        } else {
            $swap = DataReference::query()
                ->where( 'parent_id', $dataReference->id )
                ->where( 'sort', '>', $currentSort )
                ->orderBy( 'sort', 'asc' )
                ->first();
        }

        if ( ! $swap ) {
            return response()->json( ['success' => false, 'message' => 'Cannot move further'], 400 );
        }

        $swapSort = $swap->sort;
        $child->update( ['sort' => $swapSort, 'updated_by' => auth()->id()] );
        $swap->update( ['sort' => $currentSort, 'updated_by' => auth()->id()] );

        return response()->json( ['success' => true] );
    }

    /**
     * Update sort order of a data reference.
     */
    public function updateSort( Request $request, DataReference $dataReference ): JsonResponse
    {
        $direction = $request->input( 'direction' );

        if ( ! in_array( $direction, ['up', 'down'], true ) ) {
            return response()->json( ['success' => false, 'message' => 'Invalid direction'], 400 );
        }

        $currentSort = $dataReference->sort;

        if ( $direction === 'up' ) {
            $swap = DataReference::query()
                ->where( 'sort', '<', $currentSort )
                ->orderBy( 'sort', 'desc' )
                ->first();
        } else {
            $swap = DataReference::query()
                ->where( 'sort', '>', $currentSort )
                ->orderBy( 'sort', 'asc' )
                ->first();
        }

        if ( ! $swap ) {
            return response()->json( ['success' => false, 'message' => 'Cannot move further'], 400 );
        }

        $swapSort = $swap->sort;
        $dataReference->update( ['sort' => $swapSort, 'updated_by' => auth()->id()] );
        $swap->update( ['sort' => $currentSort, 'updated_by' => auth()->id()] );

        return response()->json( ['success' => true] );
    }

    /**
     * @return array<int, string>
     */
    private function getParentOptions( ?int $excludeId = null ): array
    {
        return DataReference::query()
            ->when( $excludeId, fn ( $q ) => $q->where( 'id', '!=', $excludeId ) )
            ->ordered()
            ->pluck( 'name', 'id' )
            ->all();
    }

    /**
     * Build sort position options for dropdown.
     */
    private function buildSortOptions( ?int $excludeId = null ): array
    {
        $items = DataReference::query()
            ->whereNull( 'deleted_at' )
            ->when( $excludeId, fn ( $q ) => $q->where( 'id', '!=', $excludeId ) )
            ->orderBy( 'sort', 'asc' )
            ->get( ['id', 'name', 'sort'] );

        $options  = [];
        $position = 1;

        $options[$position] = __( 'modules/reference/data-reference.sort_options.first' );
        $position++;

        foreach ( $items as $item ) {
            $options[$position] = __( 'modules/reference/data-reference.sort_options.after', [
                'position' => $this->ordinal( $position ),
                'name'     => $item->name,
            ] );
            $position++;
        }

        return $options;
    }

    /**
     * Build sort position options for child dropdown.
     *
     * @return array<int, string>
     */
    private function buildChildSortOptions( int $parentId, ?int $excludeId = null ): array
    {
        $items = DataReference::query()
            ->where( 'parent_id', $parentId )
            ->whereNull( 'deleted_at' )
            ->when( $excludeId, fn ( $q ) => $q->where( 'id', '!=', $excludeId ) )
            ->orderBy( 'sort', 'asc' )
            ->get( ['id', 'label_ms', 'label_en', 'sort'] );

        $options  = [];
        $position = 1;

        $options[$position] = __( 'modules/reference/data-reference.sort_options.first' );
        $position++;

        foreach ( $items as $item ) {
            $label = $item->label_ms ?? $item->label_en ?? '—';

            $options[$position] = __( 'modules/reference/data-reference.sort_options.after', [
                'position' => $this->ordinal( $position ),
                'name'     => $label,
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
