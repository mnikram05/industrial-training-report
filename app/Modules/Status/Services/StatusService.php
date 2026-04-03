<?php

declare(strict_types=1);

namespace App\Modules\Status\Services;

use LogicException;
use App\Support\Status\Status;
use App\Support\Status\StatusType;
use App\Support\Status\StatusCatalog;
use App\Modules\Status\Dtos\StatusDto;
use Illuminate\Contracts\Auth\Authenticatable;
use App\Support\Activity\Concerns\LogsModuleCrudActivity;

class StatusService
{
    use LogsModuleCrudActivity;

    private const LOG_NAME = 'statuses';

    private const RESOURCE_LABEL = 'Status';

    /**
     * @return array<string, string>
     */
    public function getTypeOptions(): array
    {
        $options = [];

        foreach ( StatusType::cases() as $type ) {
            $options[$type->value] = match ( $type ) {
                StatusType::Module       => __( 'ui.module' ),
                StatusType::Article      => __( 'ui.article' ),
                StatusType::Landing      => __( 'ui.landing' ),
                StatusType::DataTransfer => __( 'ui.data_transfer' ),
            };
        }

        return $options;
    }

    /**
     * @return array<int|string, string>
     */
    public function getModuleParentOptions(): array
    {
        /** @var array<string, string> $options */
        $options = [];

        $moduleStatuses = Status::query()
            ->forType( StatusType::Module )
            ->orderBy( 'name_en' )
            ->get( ['id', 'key', 'name_en', 'name_ms'] );

        foreach ( $moduleStatuses as $status ) {
            $options[(string) $status->id] = sprintf( '%s (%s)', $status->label(), $status->key );
        }

        return $options;
    }

    public function createStatus( StatusDto $data, ?Authenticatable $causer = null ): Status
    {
        $status = new Status;
        $status->fill( $this->payload( $data ) );
        $status->save();

        StatusCatalog::reset();
        $this->logCreateAction( self::LOG_NAME, self::RESOURCE_LABEL, $causer, $status );

        return $status;
    }

    public function updateStatus( Status $status, StatusDto $data, ?Authenticatable $causer = null ): Status
    {
        $status->update( $this->payload( $data ) );

        $status = $status->refresh();

        StatusCatalog::reset();
        $this->logUpdateAction( self::LOG_NAME, self::RESOURCE_LABEL, $causer, $status );

        return $status;
    }

    public function deleteStatus( Status $status, ?Authenticatable $causer = null ): bool
    {
        $deleted = (bool) $status->delete();

        if ( $deleted ) {
            StatusCatalog::reset();
            $this->logDeleteAction( self::LOG_NAME, self::RESOURCE_LABEL, $causer, $status );
        }

        return $deleted;
    }

    /**
     * @return array{type: string, key: string, parent_id: int|null, name_en: string, name_ms: string}
     */
    private function payload( StatusDto $data ): array
    {
        return [
            'type'      => $data->type,
            'key'       => $data->key,
            'parent_id' => $this->resolveParentId( $data ),
            'name_en'   => $data->nameEn,
            'name_ms'   => $data->nameMs,
        ];
    }

    private function resolveParentId( StatusDto $data ): ?int
    {
        if ( $data->type === StatusType::Module->value ) {
            return null;
        }

        if ( is_int( $data->parentId ) && $data->parentId > 0 ) {
            return $data->parentId;
        }

        $parentId = Status::query()
            ->forType( StatusType::Module )
            ->where( 'key', $data->type )
            ->value( 'id' );

        if ( is_numeric( $parentId ) ) {
            return (int) $parentId;
        }

        throw new LogicException( sprintf( 'Missing module parent for status type [%s].', $data->type ) );
    }
}
