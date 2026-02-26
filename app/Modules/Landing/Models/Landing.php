<?php

declare(strict_types=1);

namespace App\Modules\Landing\Models;

use Illuminate\Support\Str;
use Laravel\Scout\Searchable;
use App\Support\Status\Status;
use App\Support\Status\StatusType;
use App\Support\Status\StatusCatalog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Laravel\Scout\Attributes\SearchUsingPrefix;
use App\Modules\Landing\Enums\LandingStatusEnum;
use Laravel\Scout\Attributes\SearchUsingFullText;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string $slug
 * @property array<string|int, mixed>|null $content
 * @property int $status_id
 */
class Landing extends Model
{
    use Searchable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'slug',
        'content',
        'status_id',
        'status',
        'is_published',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'content' => 'array',
        ];
    }

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::creating( function ( self $landing ): void {
            if ( $landing->slug === '' ) {
                $landing->slug = self::generateUniqueSlug( self::slugSourceFromContent( $landing->content ) );
            }
        } );
    }

    /**
     * Generate a unique slug from title.
     */
    public static function generateUniqueSlug( string $title ): string
    {
        $baseSlug = Str::slug( $title );

        if ( $baseSlug === '' ) {
            $baseSlug = 'landing';
        }

        $slug    = $baseSlug;
        $counter = 1;

        while ( self::query()->where( 'slug', $slug )->exists() ) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    /**
     * Get the status row linked to this landing.
     *
     * @return BelongsTo<Status, $this>
     */
    public function statusRecord(): BelongsTo
    {
        return $this->belongsTo( Status::class, 'status_id' );
    }

    /**
     * Scope a query to search by localized name, slug, or content.
     *
     * @param  Builder<self>  $query
     * @return Builder<self>
     */
    public function scopeSearch( Builder $query, string $search ): Builder
    {
        if ( $search === '' ) {
            return $query;
        }

        return $query->where( function ( Builder $query ) use ( $search ): void {
            $query->where( 'slug', 'like', '%' . $search . '%' )
                ->orWhere( 'content', 'like', '%' . $search . '%' );
        } );
    }

    /**
     * Get the indexable data array for Scout.
     *
     * @return array{id: int, slug: string, content: string}
     */
    #[SearchUsingPrefix( ['id', 'slug'] )]
    #[SearchUsingFullText( ['content'] )]
    public function toSearchableArray(): array
    {
        $key        = $this->getKey();
        $rawContent = $this->getAttributeFromArray( 'content' );

        return [
            'id'      => is_int( $key ) ? $key : 0,
            'slug'    => (string) $this->slug,
            'content' => is_string( $rawContent ) ? $rawContent : '',
        ];
    }

    /**
     * Scope a query to only include published landings.
     *
     * @param  Builder<self>  $query
     * @return Builder<self>
     */
    public function scopePublished( Builder $query ): Builder
    {
        return $query->where( 'status_id', LandingStatusEnum::Published->id() );
    }

    public function getTitleAttribute(): string
    {
        return $this->localizedName();
    }

    public function setTitleAttribute( ?string $value ): void
    {
        $title = is_string( $value ) ? trim( $value ) : '';

        if ( $title === '' ) {
            return;
        }

        $content = is_array( $this->content ) ? $this->content : [];
        data_set( $content, 'hero.title.en', $title );
        data_set( $content, 'hero.title.ms', $title );
        $this->setAttribute( 'content', $content );
    }

    public function getStatusAttribute(): LandingStatusEnum
    {
        $statusKey = StatusCatalog::keyById( StatusType::Landing, $this->status_id );

        return LandingStatusEnum::tryFrom( (string) $statusKey ) ?? LandingStatusEnum::default();
    }

    public function setStatusAttribute( LandingStatusEnum|string|int|null $value ): void
    {
        if ( $value instanceof LandingStatusEnum ) {
            $this->attributes['status_id'] = $value->id();

            return;
        }

        if ( is_int( $value ) && $value > 0 ) {
            $this->attributes['status_id'] = $value;

            return;
        }

        if ( is_string( $value ) ) {
            $status = LandingStatusEnum::tryFrom( $value );

            if ( $status instanceof LandingStatusEnum ) {
                $this->attributes['status_id'] = $status->id();

                return;
            }
        }

        $this->attributes['status_id'] = LandingStatusEnum::default()->id();
    }

    public function getIsPublishedAttribute(): bool
    {
        return $this->status === LandingStatusEnum::Published;
    }

    public function setIsPublishedAttribute( bool|int|string|null $value ): void
    {
        $isPublished = in_array( $value, [true, 1, '1', 'true', 'on'], true );

        $this->attributes['status_id'] = $isPublished
            ? LandingStatusEnum::Published->id()
            : LandingStatusEnum::Draft->id();
    }

    public function localizedName( ?string $locale = null ): string
    {
        $activeLocale = $locale ?? app()->getLocale();
        $title        = self::localizedTextValue( data_get( $this->content, 'hero.title' ), $activeLocale );

        if ( $title !== '' ) {
            return $title;
        }

        $appName = self::stringValue( config( 'app.name', 'Laravel' ) );

        return $appName !== '' ? $appName : 'Laravel';
    }

    private static function slugSourceFromContent( mixed $content ): string
    {
        if ( ! is_array( $content ) ) {
            return 'landing';
        }

        $englishTitle = self::localizedTextValue( data_get( $content, 'hero.title' ), 'en' );

        if ( $englishTitle !== '' ) {
            return $englishTitle;
        }

        $malayTitle = self::localizedTextValue( data_get( $content, 'hero.title' ), 'ms' );

        return $malayTitle !== '' ? $malayTitle : 'landing';
    }

    private static function localizedTextValue( mixed $value, string $locale ): string
    {
        if ( is_array( $value ) ) {
            $primary = $locale === 'ms'
                ? self::stringValue( $value['ms'] ?? null )
                : self::stringValue( $value['en'] ?? null );
            $fallback = $locale === 'ms'
                ? self::stringValue( $value['en'] ?? null )
                : self::stringValue( $value['ms'] ?? null );

            return $primary !== '' ? $primary : $fallback;
        }

        return self::stringValue( $value );
    }

    private static function stringValue( mixed $value ): string
    {
        return is_scalar( $value ) ? trim( (string) $value ) : '';
    }
}
