<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contracts\Importable;
use Illuminate\Http\UploadedFile;
use App\Events\ModuleActionOccurred;
use Illuminate\Http\RedirectResponse;
use App\Support\Activity\ActivityEvent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Context;
use App\Support\Import\ModuleImportService;
use App\Support\Activity\ActivityDescription;

abstract class AbstractModuleImportController extends Controller
{
    protected const AUTHORIZATION_TARGET = Model::class;

    protected const RESOURCE_NAME = '';

    protected const IMPORT_CLASS = Importable::class;

    protected const LOG_NAME = '';

    protected const RESOURCE_LABEL = '';

    protected const INDEX_ROUTE_NAME = '';

    public function __construct(
        protected ModuleImportService $moduleImportService,
    ) {}

    protected function handleImport( Request $request ): RedirectResponse
    {
        $this->authorize( 'create', $this->authorizationTarget() );

        Context::add( [
            'transfer.operation' => 'import',
            'transfer.resource'  => $this->resourceName(),
            'transfer.user_id'   => $request->user()?->getAuthIdentifier(),
        ] );

        $file = $request->file( 'file' );

        if ( ! $file instanceof UploadedFile ) {
            abort( 422 );
        }

        $importResult = $this->moduleImportService->queue(
            $file,
            $this->resourceName(),
            $this->importClass(),
            $request->user(),
        );

        Context::add( [
            'transfer.id'            => $importResult->transferId,
            'transfer.original_file' => $importResult->originalFilename,
            'transfer.stored_path'   => $importResult->storedPath,
        ] );

        ModuleActionOccurred::log(
            logName: $this->logName(),
            event: ActivityEvent::Imported,
            description: ActivityDescription::importXlsx( __( $this->resourceLabel() ) ),
            causer: $request->user(),
            properties: [
                'filename'    => $importResult->originalFilename,
                'path'        => $importResult->storedPath,
                'transfer_id' => $importResult->transferId,
            ],
        );

        return redirect()
            ->route( $this->indexRouteName() )
            ->with( 'status', $this->resourceName() . '-imported' );
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
     * @return class-string<Importable>
     */
    private function importClass(): string
    {
        $class = static::IMPORT_CLASS;

        if ( ! is_string( $class ) || ! is_a( $class, Importable::class, true ) ) {
            return Importable::class;
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
