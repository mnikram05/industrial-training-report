<?php

declare(strict_types=1);

namespace App\Support\Status;

use RuntimeException;

final class StatusCatalog
{
    /**
     * @var array<string, array<string, array{id: int, name_en: string, name_ms: string}>>
     */
    private static array $recordsByTypeAndKey = [];

    /**
     * @var array<string, array<int, string>>
     */
    private static array $keyByTypeAndId = [];

    /**
     * @var array<string, int>
     */
    private static array $moduleParentIdsByType = [];

    /**
     * @return array<string, array{id: int, label: string}>
     */
    public static function options( StatusType $type, ?string $locale = null ): array
    {
        self::load();

        $records = self::$recordsByTypeAndKey[$type->value] ?? [];
        $options = [];

        foreach ( $records as $key => $record ) {
            $options[$key] = [
                'id'    => $record['id'],
                'label' => self::resolveLabel( $record['name_en'], $record['name_ms'], $locale ),
            ];
        }

        return $options;
    }

    public static function id( StatusType $type, string $key ): int
    {
        self::load();

        $record = self::$recordsByTypeAndKey[$type->value][$key] ?? null;

        if ( is_array( $record ) ) {
            return (int) $record['id'];
        }

        throw new RuntimeException( sprintf( 'Missing status mapping for [%s:%s].', $type->value, $key ) );
    }

    public static function keyById( StatusType $type, ?int $statusId ): ?string
    {
        if ( ! is_int( $statusId ) || $statusId <= 0 ) {
            return null;
        }

        self::load();

        return self::$keyByTypeAndId[$type->value][$statusId] ?? null;
    }

    public static function moduleParentId( StatusType $type ): int
    {
        self::load();

        $parentId = self::$moduleParentIdsByType[$type->value] ?? null;

        if ( is_int( $parentId ) ) {
            return $parentId;
        }

        throw new RuntimeException( sprintf( 'Missing module parent id for [%s].', $type->value ) );
    }

    public static function label( StatusType $type, string $key, ?string $locale = null ): string
    {
        self::load();

        $record = self::$recordsByTypeAndKey[$type->value][$key] ?? null;

        if ( is_array( $record ) ) {
            return self::resolveLabel( $record['name_en'], $record['name_ms'], $locale );
        }

        return $key;
    }

    public static function reset(): void
    {
        self::$recordsByTypeAndKey   = [];
        self::$keyByTypeAndId        = [];
        self::$moduleParentIdsByType = [];
    }

    private static function load(): void
    {
        if ( self::$recordsByTypeAndKey !== [] ) {
            return;
        }

        $records = Status::query()
            ->select( ['id', 'type', 'key', 'parent_id', 'name_en', 'name_ms'] )
            ->get()
            ->all();

        foreach ( $records as $status ) {
            if ( (string) $status->type !== StatusType::Module->value ) {
                continue;
            }

            $moduleType = (string) $status->key;

            if ( $moduleType === '' ) {
                continue;
            }

            self::$moduleParentIdsByType[$moduleType] = (int) $status->id;
        }

        foreach ( $records as $status ) {
            $type     = (string) $status->type;
            $key      = (string) $status->key;
            $id       = (int) $status->id;
            $parentId = is_numeric( $status->parent_id ) ? (int) $status->parent_id : null;

            if ( $type === StatusType::Module->value ) {
                continue;
            }

            $expectedParentId = self::$moduleParentIdsByType[$type] ?? null;

            if ( is_int( $expectedParentId ) && $parentId !== $expectedParentId ) {
                continue;
            }

            self::$recordsByTypeAndKey[$type][$key] = [
                'id'      => $id,
                'name_en' => (string) $status->name_en,
                'name_ms' => (string) $status->name_ms,
            ];

            self::$keyByTypeAndId[$type][$id] = $key;
        }
    }

    private static function resolveLabel( string $nameEn, string $nameMs, ?string $locale = null ): string
    {
        $activeLocale = $locale ?? app()->getLocale();

        if ( $activeLocale === 'ms' ) {
            return $nameMs;
        }

        return $nameEn;
    }
}
