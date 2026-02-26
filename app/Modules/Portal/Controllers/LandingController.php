<?php

declare(strict_types=1);

namespace App\Modules\Portal\Controllers;

use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Modules\Article\Services\ArticleService;
use App\Modules\Landing\Services\LandingService;

class LandingController extends Controller
{
    public function __construct(
        protected LandingService $landingService,
        protected ArticleService $articleService
    ) {}

    /**
     * Display the landing page.
     */
    public function __invoke(): View
    {
        $landing = $this->landingService->getBySlug( 'landing' );

        if ( ! $landing?->is_published ) {
            $landing = $this->landingService->getLatestPublished();
        }

        $defaultContent = $this->landingService->getDefaultLandingContent();
        $landingContent = $landing && is_array( $landing->content )
            ? $landing->content
            : [];
        $rawContent = array_replace_recursive( $defaultContent, $landingContent );
        $content    = $this->landingService->localizeContent( $rawContent );

        $articles = $rawContent['articles'] ?? [];
        $slugs    = [];

        if ( is_array( $articles ) ) {
            foreach ( $articles as $article ) {
                if ( ! is_array( $article ) ) {
                    continue;
                }

                $slug = $article['article_slug'] ?? $article['post_slug'] ?? null;

                if ( is_string( $slug ) && $slug !== '' ) {
                    $slugs[] = $slug;
                }
            }
        }

        $slugs = array_values( array_unique( $slugs ) );

        return view( 'portal.landing', [
            'landing'      => $landing,
            'content'      => $content,
            'articlePosts' => $this->articleService->getPublishedArticlesBySlug( $slugs ),
            'canRegister'  => Route::has( 'register' ),
        ] );
    }
}
