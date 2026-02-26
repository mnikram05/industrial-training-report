<?php

declare(strict_types=1);

namespace App\Modules\Landing\Services;

use Illuminate\Support\Arr;
use App\Modules\Landing\Models\Landing;
use App\Modules\Landing\Dtos\LandingDto;
use Illuminate\Contracts\Auth\Authenticatable;
use App\Support\Activity\Concerns\LogsModuleCrudActivity;

class LandingService
{
    use LogsModuleCrudActivity;

    private const LOG_NAME = 'landings';

    private const RESOURCE_LABEL = 'Landing';

    /**
     * @var list<string>
     */
    private const TRANSLATABLE_TEXT_PATHS = [
        'hero.title',
        'hero.subtitle',
        'hero.primary_button.text',
        'hero.secondary_button.text',
        'banner.title',
        'banner.subtitle',
        'banner.alt',
        'about.title',
        'about.body',
        'about.alt',
        'security.title',
        'security.body',
        'security.alt',
        'footer.text',
    ];

    /**
     * @var array<string, list<string>>
     */
    private const TRANSLATABLE_REPEATERS = [
        'articles' => ['title', 'excerpt', 'alt'],
        'features' => ['title', 'description'],
    ];

    /**
     * Get a landing by slug.
     */
    public function getBySlug( string $slug ): ?Landing
    {
        return Landing::query()
            ->where( 'slug', $slug )
            ->first();
    }

    /**
     * Get the latest published landing.
     */
    public function getLatestPublished(): ?Landing
    {
        return Landing::query()
            ->published()
            ->orderByDesc( 'updated_at' )
            ->orderByDesc( 'id' )
            ->first();
    }

    /**
     * Get default landing page content.
     *
     * @return array<string|int, mixed>
     */
    public function getDefaultLandingContent(): array
    {
        $default = config( 'landing.default', [] );

        return is_array( $default ) ? $default : [];
    }

    /**
     * @param  array<string|int, mixed>  $content
     * @return array<string|int, mixed>
     */
    public function normalizeMultilingualContent( array $content ): array
    {
        $normalized = $content;

        foreach ( self::TRANSLATABLE_TEXT_PATHS as $path ) {
            Arr::set( $normalized, $path, $this->localizedPair( data_get( $content, $path ) ) );
        }

        foreach ( self::TRANSLATABLE_REPEATERS as $section => $fields ) {
            $items = data_get( $content, $section, [] );

            if ( ! is_array( $items ) ) {
                continue;
            }

            foreach ( $items as $index => $item ) {
                if ( ! is_array( $item ) ) {
                    continue;
                }

                foreach ( $fields as $field ) {
                    $path = "{$section}.{$index}.{$field}";
                    Arr::set( $normalized, $path, $this->localizedPair( data_get( $content, $path ) ) );
                }
            }
        }

        return $normalized;
    }

    /**
     * @param  array<string|int, mixed>  $content
     * @return array<string|int, mixed>
     */
    public function localizeContent( array $content, ?string $locale = null ): array
    {
        $localized = $content;

        foreach ( self::TRANSLATABLE_TEXT_PATHS as $path ) {
            Arr::set( $localized, $path, $this->localizedTextValue( data_get( $content, $path ), $locale ) );
        }

        foreach ( self::TRANSLATABLE_REPEATERS as $section => $fields ) {
            $items = data_get( $content, $section, [] );

            if ( ! is_array( $items ) ) {
                continue;
            }

            foreach ( $items as $index => $item ) {
                if ( ! is_array( $item ) ) {
                    continue;
                }

                foreach ( $fields as $field ) {
                    $path = "{$section}.{$index}.{$field}";
                    Arr::set( $localized, $path, $this->localizedTextValue( data_get( $content, $path ), $locale ) );
                }
            }
        }

        return $localized;
    }

    /**
     * @param  array<string|int, mixed>  $content
     */
    public function localizedContentText( array $content, string $path, ?string $locale = null ): string
    {
        return $this->localizedTextValue( data_get( $content, $path ), $locale );
    }

    /**
     * Create a landing.
     */
    public function createLanding( LandingDto $data, ?Authenticatable $causer = null ): Landing
    {
        $landing = Landing::create( [
            'slug'      => $data->slug ?? '',
            'content'   => $data->content,
            'status_id' => $data->statusIdOrDefault(),
        ] );

        $this->logCreateAction( self::LOG_NAME, self::RESOURCE_LABEL, $causer, $landing );

        return $landing;
    }

    /**
     * Update a landing.
     */
    public function updateLanding( Landing $landing, LandingDto $data, ?Authenticatable $causer = null ): Landing
    {
        $landing->update( [
            'slug'      => $data->slug ?? $landing->slug,
            'content'   => $data->content,
            'status_id' => $data->statusId ?? $landing->status_id,
        ] );

        $landing = $landing->refresh();

        $this->logUpdateAction( self::LOG_NAME, self::RESOURCE_LABEL, $causer, $landing );

        return $landing;
    }

    /**
     * Delete a landing.
     */
    public function deleteLanding( Landing $landing, ?Authenticatable $causer = null ): bool
    {
        $deleted = (bool) $landing->delete();

        if ( $deleted ) {
            $this->logDeleteAction( self::LOG_NAME, self::RESOURCE_LABEL, $causer, $landing );
        }

        return $deleted;
    }

    /**
     * @return array{en: string, ms: string}
     */
    private function localizedPair( mixed $value ): array
    {
        if ( is_array( $value ) ) {
            $english = $this->stringValue( $value['en'] ?? null );
            $malay   = $this->stringValue( $value['ms'] ?? null );

            if ( $english === '' && $malay !== '' ) {
                $english = $malay;
            }

            if ( $malay === '' && $english !== '' ) {
                $malay = $english;
            }

            return [
                'en' => $english,
                'ms' => $malay,
            ];
        }

        $text = $this->stringValue( $value );

        return [
            'en' => $text,
            'ms' => $text,
        ];
    }

    private function localizedTextValue( mixed $value, ?string $locale = null ): string
    {
        $activeLocale = $locale ?? app()->getLocale();

        if ( is_array( $value ) ) {
            $primary = $activeLocale === 'ms'
                ? $this->stringValue( $value['ms'] ?? null )
                : $this->stringValue( $value['en'] ?? null );
            $fallback = $activeLocale === 'ms'
                ? $this->stringValue( $value['en'] ?? null )
                : $this->stringValue( $value['ms'] ?? null );

            return $primary !== '' ? $primary : $fallback;
        }

        return $this->stringValue( $value );
    }

    private function stringValue( mixed $value ): string
    {
        if ( is_scalar( $value ) ) {
            return trim( (string) $value );
        }

        return '';
    }
}
