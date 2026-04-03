<?php

declare(strict_types=1);

namespace Modules\PortalAdministration\Models;

use Illuminate\Database\Eloquent\Builder;
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

    /**
     * Imej terbaharu dalam Media yang biasa digunakan sebagai logo lalai (nama "logo" atau fail logo.png).
     */
    public static function fallbackLogoMediaPath(): ?string
    {
        $path = Media::query()
            ->where( function ( Builder $q ): void {
                $q->whereRaw( 'LOWER(COALESCE(name, "")) = ?', ['logo'] )
                    ->orWhereRaw( 'LOWER(COALESCE(file_name, "")) = ?', ['logo.png'] );
            } )
            ->where( 'mime_type', 'like', 'image/%' )
            ->latest( 'id' )
            ->value( 'path' );

        return is_string( $path ) && $path !== '' ? $path : null;
    }

    /**
     * Lalai logo portal/CMS: nilai tetapan header-footer, atau sandaran Media di atas.
     */
    public static function resolvedLogoPathForHeaderFooter(): ?string
    {
        $explicit = self::getValue( 'logo_path', null, 'header-footer' );

        if ( is_string( $explicit ) && $explicit !== '' ) {
            return $explicit;
        }

        return self::fallbackLogoMediaPath();
    }

    /**
     * Lalai bar CMS: logo khas CMS jika ada, jika tidak sama seperti {@see resolvedLogoPathForHeaderFooter()}.
     */
    public static function resolvedCmsBarLogoPath(): ?string
    {
        $cmsOnly = self::getValue( 'cms_logo_path', null, 'cms' )
            ?? self::getValue( 'cms_logo_path', null, 'header-footer' );

        if ( is_string( $cmsOnly ) && $cmsOnly !== '' ) {
            return $cmsOnly;
        }

        return self::resolvedLogoPathForHeaderFooter();
    }

    /**
     * Nama paparan header (Tetapan Umum / header-footer), selari dengan bar CMS dan header portal awam.
     */
    public static function headerSiteDisplayName( ?string $locale = null ): string
    {
        $locale = $locale ?? app()->getLocale();
        $page = 'header-footer';
        $primaryKey = $locale === 'ms' ? 'site_name_ms' : 'site_name_en';
        $fallbackKey = $locale === 'ms' ? 'site_name_en' : 'site_name_ms';
        $name = self::getValue( $primaryKey, null, $page )
            ?: self::getValue( $fallbackKey, null, $page );

        if ( is_string( $name ) && $name !== '' ) {
            return $name;
        }

        return (string) config( 'app.name' );
    }
}
