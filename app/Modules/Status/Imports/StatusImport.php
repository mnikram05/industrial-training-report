<?php

declare(strict_types=1);

namespace App\Modules\Status\Imports;

use App\Contracts\Importable;
use App\Support\Status\Status;
use App\Support\Status\StatusType;
use Illuminate\Support\Facades\DB;
use App\Support\Status\StatusCatalog;
use Illuminate\Support\LazyCollection;
use App\Support\Import\Concerns\InteractsWithXlsxRows;

class StatusImport implements Importable
{
    use InteractsWithXlsxRows;

    private const CHUNK_SIZE = 1_000;

    public function import( string $filePath, string|int|null $initiatedBy = null ): void
    {
        DB::disableQueryLog();

        $this->rows( $filePath )
            ->chunk( self::CHUNK_SIZE )
            ->each( function ( LazyCollection $chunk ): void {
                $now        = now();
                $moduleRows = [];
                $childRows  = [];

                foreach ( $chunk as $row ) {
                    $type = $this->normalizeType( $this->value( $row, 'type' ) );
                    $key  = $this->value( $row, 'key' );

                    if ( $type === null || $key === null ) {
                        continue;
                    }

                    $nameEn = $this->value( $row, 'name_en' ) ?? $key;
                    $nameMs = $this->value( $row, 'name_ms' ) ?? $nameEn;

                    if ( $type === StatusType::Module->value ) {
                        $moduleRows[] = [
                            'type'       => $type,
                            'key'        => $key,
                            'parent_id'  => null,
                            'name_en'    => $nameEn,
                            'name_ms'    => $nameMs,
                            'created_at' => $now,
                            'updated_at' => $now,
                        ];

                        continue;
                    }

                    $parentIdValue = $this->value( $row, 'parent_id' );
                    $parentId      = is_numeric( $parentIdValue ) ? (int) $parentIdValue : null;
                    $parentKey     = $this->value( $row, 'parent_key' ) ?? $type;

                    $childRows[] = [
                        'type'       => $type,
                        'key'        => $key,
                        'parent_id'  => $parentId,
                        'parent_key' => $parentKey,
                        'name_en'    => $nameEn,
                        'name_ms'    => $nameMs,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];
                }

                if ( $moduleRows !== [] ) {
                    Status::query()->upsert(
                        $moduleRows,
                        ['type', 'key'],
                        ['parent_id', 'name_en', 'name_ms', 'updated_at'],
                    );
                }

                if ( $childRows === [] ) {
                    return;
                }

                $moduleParents = Status::query()
                    ->where( 'type', StatusType::Module->value )
                    ->pluck( 'id', 'key' )
                    ->all();

                $moduleParentIds = [];

                foreach ( $moduleParents as $moduleKey => $moduleParentId ) {
                    if ( ! is_string( $moduleKey ) || ! is_numeric( $moduleParentId ) ) {
                        continue;
                    }

                    $moduleParentIds[$moduleKey] = (int) $moduleParentId;
                }

                $rowsToUpsert = [];

                foreach ( $childRows as $childRow ) {
                    $resolvedParentId = $childRow['parent_id'];

                    if ( ! is_int( $resolvedParentId ) || $resolvedParentId <= 0 ) {
                        $parentKey = $childRow['parent_key'];

                        $resolvedParentId = $moduleParentIds[$parentKey] ?? null;
                    }

                    if ( ! is_int( $resolvedParentId ) || $resolvedParentId <= 0 ) {
                        continue;
                    }

                    $rowsToUpsert[] = [
                        'type'       => $childRow['type'],
                        'key'        => $childRow['key'],
                        'parent_id'  => $resolvedParentId,
                        'name_en'    => $childRow['name_en'],
                        'name_ms'    => $childRow['name_ms'],
                        'created_at' => $childRow['created_at'],
                        'updated_at' => $childRow['updated_at'],
                    ];
                }

                if ( $rowsToUpsert === [] ) {
                    return;
                }

                Status::query()->upsert(
                    $rowsToUpsert,
                    ['type', 'key'],
                    ['parent_id', 'name_en', 'name_ms', 'updated_at'],
                );
            } );

        StatusCatalog::reset();
    }

    private function normalizeType( ?string $type ): ?string
    {
        if ( $type === null ) {
            return null;
        }

        $normalized = strtolower( trim( $type ) );

        if ( $normalized === '' ) {
            return null;
        }

        $allowed = array_map( static fn ( StatusType $case ): string => $case->value, StatusType::cases() );

        return in_array( $normalized, $allowed, true )
            ? $normalized
            : null;
    }
}
