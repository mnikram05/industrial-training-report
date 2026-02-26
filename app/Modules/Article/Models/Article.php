<?php

declare(strict_types=1);

namespace App\Modules\Article\Models;

use Illuminate\Support\Str;
use Laravel\Scout\Searchable;
use App\Support\Status\Status;
use App\Modules\User\Models\User;
use App\Support\Status\StatusType;
use App\Support\Status\StatusCatalog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Laravel\Scout\Attributes\SearchUsingPrefix;
use App\Modules\Article\Enums\ArticleStatusEnum;
use Laravel\Scout\Attributes\SearchUsingFullText;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string $user_id
 * @property string $title
 * @property string $slug
 * @property string|null $excerpt
 * @property string $content
 * @property int $status_id
 * @property ArticleStatusEnum $status
 * @property \Illuminate\Support\Carbon|null $published_at
 */
class Article extends Model
{
    use Searchable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'excerpt',
        'content',
        'status_id',
        'status',
        'published_at',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
        ];
    }

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::creating( function ( self $article ): void {
            if ( $article->slug === '' ) {
                $article->slug = self::generateUniqueSlug( $article->title );
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
            $baseSlug = 'article';
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
     * Get the user that owns this article.
     *
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo( User::class );
    }

    /**
     * Get the status row linked to this article.
     *
     * @return BelongsTo<Status, $this>
     */
    public function statusRecord(): BelongsTo
    {
        return $this->belongsTo( Status::class, 'status_id' );
    }

    /**
     * Scope a query to only include published articles.
     *
     * @param  Builder<self>  $query
     * @return Builder<self>
     */
    public function scopePublished( Builder $query ): Builder
    {
        return $query
            ->where( 'status_id', ArticleStatusEnum::Published->id() )
            ->whereNotNull( 'published_at' )
            ->where( 'published_at', '<=', now() );
    }

    /**
     * Scope a query to only include draft articles.
     *
     * @param  Builder<self>  $query
     * @return Builder<self>
     */
    public function scopeDraft( Builder $query ): Builder
    {
        return $query->where( 'status_id', ArticleStatusEnum::Draft->id() );
    }

    /**
     * Scope a query to only include rows with non-empty slugs.
     *
     * @param  Builder<self>  $query
     * @return Builder<self>
     */
    public function scopeWithNonEmptySlug( Builder $query ): Builder
    {
        return $query
            ->whereNotNull( 'slug' )
            ->where( 'slug', '!=', '' );
    }

    /**
     * Scope a query to search by title, excerpt, or content.
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
            $query->where( 'title', 'like', '%' . $search . '%' )
                ->orWhere( 'content', 'like', '%' . $search . '%' )
                ->orWhere( 'excerpt', 'like', '%' . $search . '%' );
        } );
    }

    /**
     * Get the indexable data array for Scout.
     *
     * @return array{id: int, slug: string, title: string, excerpt: string|null, content: string}
     */
    #[SearchUsingPrefix( ['id', 'slug'] )]
    #[SearchUsingFullText( ['title', 'excerpt', 'content'] )]
    public function toSearchableArray(): array
    {
        $key = $this->getKey();

        return [
            'id'      => is_int( $key ) ? $key : 0,
            'slug'    => (string) $this->slug,
            'title'   => (string) $this->title,
            'excerpt' => is_string( $this->excerpt ) ? $this->excerpt : null,
            'content' => (string) $this->content,
        ];
    }

    /**
     * Determine whether this article is published.
     */
    public function isPublished(): bool
    {
        return $this->status === ArticleStatusEnum::Published
            && $this->published_at !== null
            && $this->published_at->isPast();
    }

    /**
     * Determine whether this article is draft.
     */
    public function isDraft(): bool
    {
        return $this->status === ArticleStatusEnum::Draft;
    }

    /**
     * Mark this article as published.
     */
    public function markPublished(): void
    {
        $this->status_id = ArticleStatusEnum::Published->id();

        if ( $this->published_at === null ) {
            $this->published_at = now();
        }
    }

    /**
     * Mark this article as draft.
     */
    public function markDraft(): void
    {
        $this->status_id = ArticleStatusEnum::Draft->id();
    }

    /**
     * Get the route key for this model.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function getStatusAttribute(): ArticleStatusEnum
    {
        $statusKey = StatusCatalog::keyById( StatusType::Article, $this->status_id );

        return ArticleStatusEnum::tryFrom( (string) $statusKey ) ?? ArticleStatusEnum::default();
    }

    public function setStatusAttribute( ArticleStatusEnum|string|int|null $value ): void
    {
        if ( $value instanceof ArticleStatusEnum ) {
            $this->attributes['status_id'] = $value->id();

            return;
        }

        if ( is_int( $value ) && $value > 0 ) {
            $this->attributes['status_id'] = $value;

            return;
        }

        if ( is_string( $value ) ) {
            $status = ArticleStatusEnum::tryFrom( $value );

            if ( $status instanceof ArticleStatusEnum ) {
                $this->attributes['status_id'] = $status->id();

                return;
            }
        }

        $this->attributes['status_id'] = ArticleStatusEnum::default()->id();
    }
}
