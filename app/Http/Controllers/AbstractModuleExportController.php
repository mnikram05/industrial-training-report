<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contracts\Exportable;
use Illuminate\Http\JsonResponse;
use App\Events\ModuleActionOccurred;
use Illuminate\Http\RedirectResponse;
use App\Support\Activity\ActivityEvent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Context;
use App\Support\Export\ModuleExportService;
use App\Support\Activity\ActivityDescription;

abstract class AbstractModuleExportController extends Controller
{
    protected const AUTHORIZATION_TARGET = Model::class;

    protected const RESOURCE_NAME = '';

    protected const EXPORT_CLASS = Exportable::class;

    protected const LOG_NAME = '';

    protected const RESOURCE_LABEL = '';

    protected const INDEX_ROUTE_NAME = '';

    public function __construct(
        protected ModuleExportService $moduleExportService,
    ) {}

    public function __invoke( Request $request ): JsonResponse|RedirectResponse
    {
        $this->authorize( 'viewAny', $this->authorizationTarget() );

        Context::add( [
            'transfer.operation' => 'export',
            'transfer.resource'  => $this->resourceName(),
            'transfer.user_id'   => $request->user()?->getAuthIdentifier(),
        ] );

        $exportResult = $this->moduleExportService->queue(
            $this->resourceName(),
            $this->exportClass(),
            $request->user(),
        );

        Context::add( [
            'transfer.id'       => $exportResult->transferId,
            'transfer.filename' => $exportResult->filename,
        ] );

        ModuleActionOccurred::log(
            logName: $this->logName(),
            event: ActivityEvent::Exported,
            description: ActivityDescription::export( __( $this->resourceLabel() ) ),
            causer: $request->user(),
            properties: [
                'filename'    => $exportResult->filename,
                'transfer_id' => $exportResult->transferId,
            ],
        );

        if ( $request->wantsJson() ) {
            return response()->json( ['download_url' => $exportResult->downloadUrl] );
        }

        return redirect()
            ->route( $this->indexRouteName() )
            ->with( 'status', 'export-started' )
            ->with( 'export_transfer_id', $exportResult->transferId );
    }

    private function authorizationTarget(): string
    {
        return is_string( static::AUTHORIZATION_TARGET )
            ? static::AUTHORIZATION_TARGET
            : Model::class;
    }

    private function resourceName(): string
    {
        return is_string( static::RESOURCE_NAME ) ? static::RESOURCE_NAME : '';
    }

    /**
     * @return class-string<Exportable>
     */
    private function exportClass(): string
    {
        $class = static::EXPORT_CLASS;

        if ( ! is_string( $class ) || ! is_a( $class, Exportable::class, true ) ) {
            return Exportable::class;
        }

        return $class;
    }

    private function logName(): string
    {
        return is_string( static::LOG_NAME ) ? static::LOG_NAME : '';
    }

    private function resourceLabel(): string
    {
        return is_string( static::RESOURCE_LABEL ) ? static::RESOURCE_LABEL : '';
    }

    private function indexRouteName(): string
    {
        return is_string( static::INDEX_ROUTE_NAME ) ? static::INDEX_ROUTE_NAME : '';
    }
}
