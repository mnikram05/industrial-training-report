<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Modules\User\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use App\Modules\Article\Models\Article;
use App\Modules\Landing\Models\Landing;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Requests\GlobalSearchRequest;

class GlobalSearchController extends Controller
{
    private const MAX_RESULTS = 5;

    private const MIN_QUERY_LENGTH = 2;

    public function __invoke( GlobalSearchRequest $request ): JsonResponse
    {
        $validatedQuery = $request->validated( 'query' );
        $query          = is_string( $validatedQuery ) ? trim( $validatedQuery ) : '';

        if ( mb_strlen( $query ) < self::MIN_QUERY_LENGTH ) {
            return response()->json( ['data' => []] );
        }

        $user = $request->user();

        if ( ! $user instanceof User ) {
            abort( 403 );
        }

        $results = [
            ...$this->searchUsers( $query ),
            ...$this->searchArticles( $query, $user ),
            ...$this->searchLandings( $query, $user ),
        ];

        usort( $results, function ( array $left, array $right ) use ( $query ): int {
            return $this->relevanceScore( $right, $query ) <=> $this->relevanceScore( $left, $query );
        } );

        $results = array_slice( $results, 0, self::MAX_RESULTS );

        return response()->json( ['data' => $results] );
    }

    /**
     * @return array<int, array{id: string, type: string, label: string, title: string, subtitle: string, url: string}>
     */
    private function searchUsers( string $query ): array
    {
        if ( ! Gate::allows( 'viewAny', User::class ) ) {
            return [];
        }

        $results = [];

        $models = User::search( $query )
            ->query( fn ( Builder $builder ): Builder => $builder->select( ['id', 'name', 'email'] ) )
            ->take( self::MAX_RESULTS )
            ->get();

        foreach ( $models as $model ) {
            if ( ! Gate::allows( 'view', $model ) ) {
                continue;
            }

            $results[] = [
                'id'       => $this->normalizeKey( $model->getKey() ),
                'type'     => 'user',
                'label'    => (string) __( 'User' ),
                'title'    => (string) $model->name,
                'subtitle' => (string) $model->email,
                'url'      => route( 'users.show', $model ),
            ];
        }

        return $results;
    }

    /**
     * @return array<int, array{id: string, type: string, label: string, title: string, subtitle: string, url: string}>
     */
    private function searchArticles( string $query, User $user ): array
    {
        if ( ! Gate::allows( 'viewAny', Article::class ) ) {
            return [];
        }

        $results = [];

        $models = Article::search( $query )
            ->query( fn ( Builder $builder ): Builder => $builder->select( ['id', 'slug', 'title', 'status_id'] ) )
            ->take( self::MAX_RESULTS )
            ->get();

        foreach ( $models as $model ) {
            if ( ! $user->can( 'update', $model ) ) {
                continue;
            }

            $results[] = [
                'id'       => $this->normalizeKey( $model->getKey() ),
                'type'     => 'article',
                'label'    => (string) __( 'Article' ),
                'title'    => (string) $model->title,
                'subtitle' => (string) $model->slug,
                'url'      => route( 'articles.edit', $model ),
            ];
        }

        return $results;
    }

    /**
     * @return array<int, array{id: string, type: string, label: string, title: string, subtitle: string, url: string}>
     */
    private function searchLandings( string $query, User $user ): array
    {
        if ( ! Gate::allows( 'viewAny', Landing::class ) ) {
            return [];
        }

        $results = [];

        $models = Landing::search( $query )
            ->query( fn ( Builder $builder ): Builder => $builder->select( ['id', 'slug', 'status_id'] ) )
            ->take( self::MAX_RESULTS )
            ->get();

        foreach ( $models as $model ) {
            if ( ! $user->can( 'update', $model ) ) {
                continue;
            }

            $results[] = [
                'id'       => $this->normalizeKey( $model->getKey() ),
                'type'     => 'landing',
                'label'    => (string) __( 'Landing' ),
                'title'    => (string) $model->slug,
                'subtitle' => (string) __( 'Landing page' ),
                'url'      => route( 'landings.edit', $model ),
            ];
        }

        return $results;
    }

    /**
     * @param  array{id: string, type: string, label: string, title: string, subtitle: string, url: string}  $result
     */
    private function relevanceScore( array $result, string $query ): int
    {
        $normalizedQuery    = mb_strtolower( trim( $query ) );
        $normalizedTitle    = mb_strtolower( trim( $result['title'] ) );
        $normalizedSubtitle = mb_strtolower( trim( $result['subtitle'] ) );

        if ( $normalizedQuery === '' ) {
            return 0;
        }

        $titleExactMatch = $normalizedTitle === $normalizedQuery ? 100 : 0;
        $titleStartsWith = str_starts_with( $normalizedTitle, $normalizedQuery ) ? 50 : 0;
        $titleContains   = str_contains( $normalizedTitle, $normalizedQuery ) ? 20 : 0;
        $subtitleStarts  = str_starts_with( $normalizedSubtitle, $normalizedQuery ) ? 10 : 0;
        $subtitleContain = str_contains( $normalizedSubtitle, $normalizedQuery ) ? 5 : 0;

        return $titleExactMatch + $titleStartsWith + $titleContains + $subtitleStarts + $subtitleContain;
    }

    private function normalizeKey( mixed $key ): string
    {
        if ( is_int( $key ) || is_string( $key ) ) {
            return (string) $key;
        }

        return '';
    }
}
