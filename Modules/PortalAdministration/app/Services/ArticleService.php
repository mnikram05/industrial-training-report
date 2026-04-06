<?php

declare(strict_types=1);

namespace Modules\PortalAdministration\Services;

use RuntimeException;
use App\Modules\User\Models\User;
use App\Events\ModuleActionOccurred;
use App\Support\Activity\ActivityEvent;
use App\Support\Activity\ActivityDescription;
use Illuminate\Contracts\Auth\Authenticatable;
use Modules\PortalAdministration\Models\Article;
use Modules\PortalAdministration\Dtos\ArticleDto;
use App\Support\Activity\Concerns\LogsModuleCrudActivity;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class ArticleService
{
    use LogsModuleCrudActivity;

    private const LOG_NAME = 'articles';

    private const RESOURCE_LABEL = 'Article';

    /**
     * Get published articles keyed by slug for public linking.
     *
     * @param  array<int, string>  $slugs
     * @return EloquentCollection<int|string, Article>
     */
    public function getPublishedArticlesBySlug( array $slugs ): EloquentCollection
    {
        if ( $slugs === [] ) {
            /** @var EloquentCollection<int|string, Article> $empty */
            $empty = new EloquentCollection;

            return $empty;
        }

        /** @var EloquentCollection<int, Article> $articles */
        $articles = Article::query()
            ->published()
            ->withNonEmptySlug()
            ->whereIn( 'slug', $slugs )
            ->orderBy( 'published_at', 'desc' )
            ->get( ['id', 'title', 'slug', 'excerpt', 'content'] );

        /** @var EloquentCollection<int|string, Article> $keyed */
        $keyed = $articles->keyBy( static fn ( Article $article ): string => (string) $article->slug );

        return $keyed;
    }

    /**
     * Get published article options keyed by slug.
     *
     * @return array<string, string>
     */
    public function getPublishedArticleOptions( ?int $limit = null ): array
    {
        $query = Article::query()
            ->published()
            ->withNonEmptySlug()
            ->orderBy( 'published_at', 'desc' );

        if ( $limit !== null ) {
            $query->limit( $limit );
        }

        return $query
            ->get( ['slug', 'title'] )
            ->mapWithKeys( static fn ( Article $article ): array => [
                (string) $article->slug => (string) $article->title,
            ] )
            ->all();
    }

    /**
     * Create a new article.
     */
    public function createArticle( User $user, ArticleDto $data ): Article
    {
        $userKey = $user->getKey();

        if ( ! is_string( $userKey ) && ! is_int( $userKey ) ) {
            throw new RuntimeException( 'Invalid user key type for article creation.' );
        }

        $article = Article::create( [
            'user_id'          => (string) $userKey,
            'menu_type_id'     => $data->menuTypeId,
            'menu_id'          => $data->menuId,
            'title_ms'         => $data->titleMy,
            'title_en'         => $data->titleEn,
            'document_type_id' => $data->documentTypeId,
            'title'            => $data->title,
            'slug'             => $data->slug ?? '',
            'excerpt'          => $data->excerpt,
            'content'          => $data->content ?? '',
            'file_path'        => $data->filePath,
            'status_id'        => $data->statusIdOrDefault(),
            'published_at'     => $data->publishedAt,
        ] );

        $this->logCreateAction( self::LOG_NAME, self::RESOURCE_LABEL, $user, $article );

        return $article;
    }

    /**
     * Update an article.
     */
    public function updateArticle( Article $article, ArticleDto $data, ?Authenticatable $causer = null ): Article
    {
        $article->update( [
            'menu_type_id'     => $data->menuTypeId,
            'menu_id'          => $data->menuId,
            'title_ms'         => $data->titleMy,
            'title_en'         => $data->titleEn,
            'document_type_id' => $data->documentTypeId,
            'title'            => $data->title,
            'slug'             => $data->slug ?? $article->slug,
            'excerpt'          => $data->excerpt,
            'content'          => $data->content ?? $article->content,
            'file_path'        => $data->filePath ?? $article->file_path,
            'status_id'        => $data->statusId ?? $article->status_id,
            'published_at'     => $data->publishedAt ?? $article->published_at?->toDateTimeString(),
        ] );

        $article = $article->refresh();

        $this->logUpdateAction( self::LOG_NAME, self::RESOURCE_LABEL, $causer, $article );

        return $article;
    }

    /**
     * Delete an article.
     */
    public function deleteArticle( Article $article, ?Authenticatable $causer = null ): bool
    {
        $deleted = (bool) $article->delete();

        if ( $deleted ) {
            $this->logDeleteAction( self::LOG_NAME, self::RESOURCE_LABEL, $causer, $article );
        }

        return $deleted;
    }

    /**
     * Publish an article.
     */
    public function publishArticle( Article $article, ?Authenticatable $causer = null ): Article
    {
        $article->markPublished();
        $article->save();

        $article = $article->refresh();

        ModuleActionOccurred::log(
            logName: 'articles',
            event: ActivityEvent::Published,
            description: ActivityDescription::publish( __( 'modules/portal-administration/article.plural' ) ),
            causer: $causer,
            subject: $article,
        );

        return $article;
    }

    /**
     * Unpublish an article.
     */
    public function unpublishArticle( Article $article, ?Authenticatable $causer = null ): Article
    {
        $article->markDraft();
        $article->save();

        $article = $article->refresh();

        ModuleActionOccurred::log(
            logName: 'articles',
            event: ActivityEvent::Unpublished,
            description: ActivityDescription::unpublish( __( 'modules/portal-administration/article.plural' ) ),
            causer: $causer,
            subject: $article,
        );

        return $article;
    }
}
