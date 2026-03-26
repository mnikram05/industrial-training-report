<?php

declare(strict_types=1);

namespace Modules\PortalAdministration\Models;

use Illuminate\Database\Eloquent\Model;

class PortalSetting extends Model
{
    protected $fillable = [
        'page',
        'key',
        'value',
    ];

    public static function getValue( string $key, ?string $default = null, string $page = 'home' ): ?string
    {
        return static::query()
            ->where( 'page', $page )
            ->where( 'key', $key )
            ->value( 'value' ) ?? $default;
    }

    public static function setValue( string $key, ?string $value, string $page = 'home' ): void
    {
        static::query()->updateOrCreate(
            ['page' => $page, 'key' => $key],
            ['value' => $value],
        );
    }

    /**
     * @return array<string, string|null>
     */
    public static function forPage( string $page = 'home' ): array
    {
        return static::query()
            ->where( 'page', $page )
            ->pluck( 'value', 'key' )
            ->all();
    }

    /**
     * @return list<array{type: string, id: string, data: array<string, mixed>}>
     */
    public static function getBlocks( string $page ): array
    {
        $raw = static::getValue( 'blocks', null, $page );

        return $raw ? ( json_decode( $raw, true ) ?: [] ) : [];
    }

    public static function setBlocks( array $blocks, string $page ): void
    {
        static::setValue( 'blocks', json_encode( $blocks ), $page );
    }

    /**
     * @return list<string>
     */
    public static function pages(): array
    {
        return static::query()
            ->distinct()
            ->pluck( 'page' )
            ->sort()
            ->values()
            ->all();
    }
}
