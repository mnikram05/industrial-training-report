<?php

declare(strict_types=1);

namespace App\Modules\Landing\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Modules\Landing\Models\Landing;
use App\Modules\Landing\Dtos\LandingDto;
use App\Modules\Landing\Requests\LandingRequest;
use App\Modules\Landing\Services\LandingService;
use App\Modules\Landing\DataTables\LandingDataTable;
use App\Modules\Landing\Services\LandingFormDataService;
use App\Support\Export\LatestCompletedExportPathResolver;
use App\Modules\Landing\Actions\PrepareLandingInputAction;

class LandingController extends Controller
{
    public function __construct(
        protected LandingService $landingService,
        protected LandingDataTable $landingDataTable,
        protected LandingFormDataService $landingFormDataService,
        protected PrepareLandingInputAction $prepareLandingInputAction,
        private LatestCompletedExportPathResolver $latestCompletedExportPathResolver,
    ) {
        $this->authorizeResource( Landing::class, 'landing' );
    }

    /**
     * Display a listing of landings.
     */
    public function index( Request $request ): JsonResponse|View
    {
        if ( $request->ajax() ) {
            return $this->landingDataTable->ajax();
        }

        $latestExportPath = $this->latestCompletedExportPathResolver->resolve( 'landings', $request->user() );

        return view( 'modules.landings.index', [
            'dataTable'        => $this->landingDataTable,
            'latestExportPath' => $latestExportPath,
        ] );
    }

    /**
     * Show the form for creating a new landing.
     */
    public function create(): View
    {
        return view( 'modules.landings.create', $this->landingFormDataService->build( null ) );
    }

    /**
     * Store a newly created landing.
     */
    public function store( LandingRequest $request ): RedirectResponse
    {
        $data = $this->prepareLandingInputAction->handle( $request );

        $landing = $this->landingService->createLanding(
            LandingDto::fromArray( $data ),
            $request->user(),
        );

        return redirect()
            ->route( 'landings.edit', $landing )
            ->with( 'status', 'landing-created' );
    }

    /**
     * Show the form for editing the specified landing.
     */
    public function edit( Landing $landing ): View
    {
        return view(
            'modules.landings.edit',
            array_merge(
                ['landing' => $landing],
                $this->landingFormDataService->build( $landing ),
            )
        );
    }

    /**
     * Update the specified landing.
     */
    public function update( LandingRequest $request, Landing $landing ): RedirectResponse
    {
        $data = $this->prepareLandingInputAction->handle( $request, $landing );

        $this->landingService->updateLanding(
            $landing,
            LandingDto::fromArray( $data ),
            $request->user(),
        );

        return redirect()
            ->route( 'landings.edit', $landing )
            ->with( 'status', 'landing-updated' );
    }

    /**
     * Remove the specified landing.
     */
    public function destroy( Request $request, Landing $landing ): RedirectResponse
    {
        $this->landingService->deleteLanding( $landing, $request->user() );

        return redirect()
            ->route( 'landings.index' )
            ->with( 'status', 'landing-deleted' );
    }
}
