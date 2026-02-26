<?php

declare(strict_types=1);

namespace App\Modules\Landing\Imports;

use Illuminate\Support\Str;
use App\Contracts\Importable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\LazyCollection;
use App\Modules\Landing\Models\Landing;
use App\Modules\Landing\Enums\LandingStatusEnum;
use App\Support\Import\Concerns\InteractsWithXlsxRows;

class LandingImport implements Importable
{
    use InteractsWithXlsxRows;

    private const CHUNK_SIZE = 1_000;

    public function import( string $filePath, string|int|null $initiatedBy = null ): void
    {
        DB::disableQueryLog();

        $this->rows( $filePath )
            ->chunk( self::CHUNK_SIZE )
            ->each( function ( LazyCollection $chunk ): void {
                $landingsBySlug = [];
                $now            = now();
                $defaultContent = config( 'landing.default', [] );
                $baseContent    = is_array( $defaultContent ) ? $defaultContent : [];

                foreach ( $chunk as $row ) {
                    $titleEn = $this->value( $row, 'title_en' )
                        ?? $this->value( $row, 'name_en' )
                        ?? $this->value( $row, 'title' );

                    if ( $titleEn === null ) {
                        continue;
                    }

                    $titleMs = $this->value( $row, 'title_ms' )
                        ?? $this->value( $row, 'name_ms' )
                        ?? $titleEn;
                    $slug = $this->value( $row, 'slug' ) ?? Str::slug( $titleEn );

                    if ( $slug === '' ) {
                        $slug = 'landing-' . Str::lower( Str::random( 8 ) );
                    }

                    $statusValue = $this->value( $row, 'status' );
                    $statusEnum  = is_string( $statusValue )
                        ? LandingStatusEnum::tryFrom( Str::lower( $statusValue ) )
                        : null;
                    $publishedValue = $row['is_published'] ?? $row['published'] ?? false;
                    $published      = filter_var( $publishedValue, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE );
                    $statusId       = $statusEnum instanceof LandingStatusEnum
                        ? $statusEnum->id()
                        : ( (bool) ( $published ?? false ) ? LandingStatusEnum::Published->id() : LandingStatusEnum::Draft->id() );
                    $content = $baseContent;
                    data_set( $content, 'hero.title.en', $titleEn );
                    data_set( $content, 'hero.title.ms', $titleMs );

                    $landingsBySlug[$slug] = [
                        'slug'       => $slug,
                        'content'    => json_encode( $content ),
                        'status_id'  => $statusId,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];
                }

                if ( $landingsBySlug === [] ) {
                    return;
                }

                Landing::query()->upsert(
                    array_values( $landingsBySlug ),
                    ['slug'],
                    ['content', 'status_id', 'updated_at'],
                );
            } );
    }
}
