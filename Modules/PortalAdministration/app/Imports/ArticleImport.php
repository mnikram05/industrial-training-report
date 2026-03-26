<?php

declare(strict_types=1);

namespace Modules\PortalAdministration\Imports;

use Illuminate\Support\Str;
use App\Contracts\Importable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\LazyCollection;
use Modules\PortalAdministration\Models\Article;
use App\Support\Import\Concerns\InteractsWithXlsxRows;
use Modules\PortalAdministration\Enums\ArticleStatusEnum;

class ArticleImport implements Importable
{
    use InteractsWithXlsxRows;

    private const CHUNK_SIZE = 1_000;

    public function import( string $filePath, string|int|null $initiatedBy = null ): void
    {
        DB::disableQueryLog();

        if ( ! is_string( $initiatedBy ) && ! is_int( $initiatedBy ) ) {
            return;
        }

        $this->rows( $filePath )
            ->chunk( self::CHUNK_SIZE )
            ->each( function ( LazyCollection $chunk ) use ( $initiatedBy ): void {
                $articleRows = [];
                $now         = now();

                foreach ( $chunk as $row ) {
                    $title = $this->value( $row, 'title' );

                    if ( $title === null ) {
                        continue;
                    }

                    $statusValue = $this->value( $row, 'status' );
                    $statusEnum  = ArticleStatusEnum::tryFrom( (string) $statusValue );
                    $statusId    = $statusEnum instanceof ArticleStatusEnum
                        ? $statusEnum->id()
                        : ArticleStatusEnum::Draft->id();

                    $slug = $this->value( $row, 'slug' );

                    if ( $slug === null ) {
                        $baseSlug = Str::slug( $title );
                        $baseSlug = $baseSlug !== '' ? $baseSlug : 'article';
                        $slug     = $baseSlug . '-' . Str::lower( Str::random( 8 ) );
                    }

                    $articleRows[$slug] = [
                        'user_id'      => (string) $initiatedBy,
                        'title'        => $title,
                        'slug'         => $slug,
                        'excerpt'      => $this->value( $row, 'excerpt' ),
                        'content'      => $this->value( $row, 'content' ) ?? '',
                        'status_id'    => $statusId,
                        'published_at' => $this->value( $row, 'published_at' ),
                        'created_at'   => $now,
                        'updated_at'   => $now,
                    ];
                }

                if ( $articleRows === [] ) {
                    return;
                }

                Article::query()->upsert(
                    array_values( $articleRows ),
                    ['slug'],
                    ['user_id', 'title', 'excerpt', 'content', 'status_id', 'published_at', 'updated_at'],
                );
            } );
    }
}
