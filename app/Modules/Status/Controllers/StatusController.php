<?php

declare(strict_types=1);

namespace App\Modules\Status\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Support\Status\Status;
use Illuminate\Http\JsonResponse;
use App\Support\Status\StatusType;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Modules\Status\Dtos\StatusDto;
use App\Modules\Status\Requests\StatusRequest;
use App\Modules\Status\Services\StatusService;
use App\Modules\Status\DataTables\StatusDataTable;
use App\Support\Export\LatestCompletedExportPathResolver;

class StatusController extends Controller
{
    public function __construct(
        protected StatusService $statusService,
        protected StatusDataTable $statusDataTable,
        private LatestCompletedExportPathResolver $latestCompletedExportPathResolver,
    ) {
        $this->authorizeResource( Status::class, 'status' );
    }

    public function index( Request $request ): JsonResponse|View
    {
        $dataTable = $this->statusDataTable->onlyModuleParents();

        if ( $request->ajax() ) {
            return $dataTable->ajax();
        }

        $latestExportPath = $this->latestCompletedExportPathResolver->resolve( 'statuses', $request->user() );

        return view( 'modules.statuses.index', [
            'dataTable'        => $dataTable,
            'latestExportPath' => $latestExportPath,
        ] );
    }

    public function create(): View
    {
        $moduleParentOptions = $this->statusService->getModuleParentOptions();

        return view( 'modules.statuses.create', [
            'typeOptions'         => $this->statusService->getTypeOptions(),
            'parentStatusOptions' => ['' => __( 'No Parent (module level)' )] + $moduleParentOptions,
        ] );
    }

    public function store( StatusRequest $request ): RedirectResponse
    {
        $status = $this->statusService->createStatus(
            StatusDto::fromArray( $request->validated() ),
            $request->user(),
        );

        return redirect()
            ->route( 'statuses.edit', $status )
            ->with( 'status', 'status-created' );
    }

    public function show( Request $request, Status $status ): JsonResponse|View
    {
        $status->loadMissing( 'parent' );

        $moduleStatus = (string) $status->type === StatusType::Module->value
            ? $status
            : $status->parent;

        if ( ! $moduleStatus instanceof Status ) {
            abort( 404 );
        }

        $dataTable = $this->statusDataTable->forParentStatus( $moduleStatus );

        if ( $request->ajax() ) {
            return $dataTable->ajax();
        }

        return view( 'modules.statuses.show', [
            'status'    => $moduleStatus,
            'dataTable' => $dataTable,
        ] );
    }

    public function edit( Status $status ): View
    {
        $status->loadMissing( 'parent:id,key,name_en,name_ms' );
        $moduleParentOptions = $this->statusService->getModuleParentOptions();

        return view( 'modules.statuses.edit', [
            'status'              => $status,
            'typeOptions'         => $this->statusService->getTypeOptions(),
            'parentStatusOptions' => ['' => __( 'No Parent (module level)' )] + $moduleParentOptions,
        ] );
    }

    public function update( StatusRequest $request, Status $status ): RedirectResponse
    {
        $this->statusService->updateStatus(
            $status,
            StatusDto::fromArray( $request->validated() ),
            $request->user(),
        );

        return redirect()
            ->route( 'statuses.edit', $status )
            ->with( 'status', 'status-updated' );
    }

    public function destroy( Request $request, Status $status ): RedirectResponse
    {
        $this->statusService->deleteStatus( $status, $request->user() );

        return redirect()
            ->route( 'statuses.index' )
            ->with( 'status', 'status-deleted' );
    }
}
