<?php

declare(strict_types=1);

namespace App\Modules\Landing\Services;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Modules\Landing\Models\Landing;
use App\Modules\Article\Services\ArticleService;
use App\Modules\Landing\Enums\LandingStatusEnum;

class LandingFormDataService
{
    public function __construct(
        protected LandingService $landingService,
        protected ArticleService $articleService,
    ) {}

    /**
     * @return array{
     *     content: array<string|int, mixed>,
     *     featureIconOptions: array<string, string>,
     *     landingStatusOptions: array<int, string>,
     *     articleOptions: array<string, string>,
     *     articleOptionLimit: int,
     *     previewData: array<string, mixed>
     * }
     */
    public function build( ?Landing $landing ): array
    {
        $defaultContent     = $this->landingService->getDefaultLandingContent();
        $landingContent     = $landing?->content;
        $articleOptionLimit = config( 'landing.article_post_limit', 500 );
        $articleOptionLimit = ( is_string( $articleOptionLimit ) && is_numeric( $articleOptionLimit ) )
            ? (int) $articleOptionLimit
            : ( is_int( $articleOptionLimit ) ? $articleOptionLimit : 500 );

        $baseContent = is_array( $landingContent )
            ? array_replace_recursive( $defaultContent, $landingContent )
            : $defaultContent;

        $oldContent = session()->getOldInput( 'content' );
        $content    = is_array( $oldContent )
            ? array_replace_recursive( $baseContent, $oldContent )
            : $baseContent;
        $articleOptions = $this->articleService->getPublishedArticleOptions( $articleOptionLimit );

        return [
            'content'              => $content,
            'featureIconOptions'   => $this->featureIconOptions(),
            'landingStatusOptions' => LandingStatusEnum::options(),
            'articleOptions'       => $articleOptions,
            'articleOptionLimit'   => $articleOptionLimit,
            'previewData'          => $this->buildPreviewData( $landing, $content, $articleOptions ),
        ];
    }

    /**
     * @return array<string, string>
     */
    private function featureIconOptions(): array
    {
        return [
            'sparkles' => __( 'Sparkles' ),
            'shield'   => __( 'Shield' ),
            'globe'    => __( 'Globe' ),
            'zap'      => __( 'Zap' ),
            'heart'    => __( 'Heart' ),
            'star'     => __( 'Star' ),
        ];
    }

    /**
     * @param  array<string|int, mixed>  $content
     * @param  array<string, string>  $articleOptions
     * @return array<string, mixed>
     */
    private function buildPreviewData( ?Landing $landing, array $content, array $articleOptions ): array
    {
        $previewArticles = [];
        $previewFeatures = [];
        $defaultSlug     = $landing instanceof Landing ? $landing->slug : '';
        $defaultStatusId = $landing instanceof Landing
            ? $landing->status_id
            : LandingStatusEnum::default()->id();
        $statusInput = old( 'status_id', (string) $defaultStatusId );

        for ( $index = 0; $index < 3; $index++ ) {
            $previewArticles[] = [
                'articleSlug' => $this->asString( data_get( $content, "articles.{$index}.article_slug", '' ) ),
                'title'       => $this->landingService->localizedContentText( $content, "articles.{$index}.title" ),
                'excerpt'     => $this->landingService->localizedContentText( $content, "articles.{$index}.excerpt" ),
                'imagePath'   => $this->asString( data_get( $content, "articles.{$index}.image", '' ) ),
                'alt'         => $this->landingService->localizedContentText( $content, "articles.{$index}.alt" ),
            ];

            $previewFeatures[] = [
                'icon'        => $this->asString( data_get( $content, "features.{$index}.icon", 'sparkles' ) ),
                'title'       => $this->landingService->localizedContentText( $content, "features.{$index}.title" ),
                'description' => $this->landingService->localizedContentText( $content, "features.{$index}.description" ),
            ];
        }

        return [
            'homeUrl'           => $this->routeIfExists( 'home', '/' ),
            'dashboardUrl'      => $this->routeIfExists( 'dashboard', '#' ),
            'loginUrl'          => $this->routeIfExists( 'login', '#' ),
            'registerUrl'       => $this->routeIfExists( 'register', '#' ),
            'isAuthenticated'   => Auth::check(),
            'canRegister'       => Route::has( 'register' ),
            'storageBaseUrl'    => url( '/storage' ),
            'locale'            => app()->getLocale(),
            'appName'           => $this->asString( config( 'app.name', 'Laravel' ) ),
            'slug'              => $this->asString( old( 'slug', $defaultSlug ) ),
            'statusId'          => is_numeric( $statusInput ) ? (int) $statusInput : LandingStatusEnum::default()->id(),
            'heroTitle'         => $this->landingService->localizedContentText( $content, 'hero.title' ),
            'heroSubtitle'      => $this->landingService->localizedContentText( $content, 'hero.subtitle' ),
            'heroPrimaryText'   => $this->landingService->localizedContentText( $content, 'hero.primary_button.text' ),
            'heroPrimaryUrl'    => $this->asString( data_get( $content, 'hero.primary_button.url', '' ) ),
            'heroSecondaryText' => $this->landingService->localizedContentText( $content, 'hero.secondary_button.text' ),
            'heroSecondaryUrl'  => $this->asString( data_get( $content, 'hero.secondary_button.url', '' ) ),
            'bannerTitle'       => $this->landingService->localizedContentText( $content, 'banner.title' ),
            'bannerSubtitle'    => $this->landingService->localizedContentText( $content, 'banner.subtitle' ),
            'bannerImagePath'   => $this->asString( data_get( $content, 'banner.image', '' ) ),
            'bannerAlt'         => $this->landingService->localizedContentText( $content, 'banner.alt' ),
            'aboutTitle'        => $this->landingService->localizedContentText( $content, 'about.title' ),
            'aboutBody'         => $this->landingService->localizedContentText( $content, 'about.body' ),
            'aboutImagePath'    => $this->asString( data_get( $content, 'about.image', '' ) ),
            'aboutAlt'          => $this->landingService->localizedContentText( $content, 'about.alt' ),
            'securityTitle'     => $this->landingService->localizedContentText( $content, 'security.title' ),
            'securityBody'      => $this->landingService->localizedContentText( $content, 'security.body' ),
            'securityImagePath' => $this->asString( data_get( $content, 'security.image', '' ) ),
            'securityAlt'       => $this->landingService->localizedContentText( $content, 'security.alt' ),
            'footerText'        => $this->landingService->localizedContentText( $content, 'footer.text' ),
            'articleOptions'    => $articleOptions,
            'articlePreviews'   => $this->buildArticlePreviews( $articleOptions ),
            'articles'          => $previewArticles,
            'features'          => $previewFeatures,
        ];
    }

    /**
     * @param  array<string, string>  $articleOptions
     * @return array<string, array{title: string, excerpt: string, url: string}>
     */
    private function buildArticlePreviews( array $articleOptions ): array
    {
        $articlePreviews = [];
        $articleSlugs    = array_keys( $articleOptions );
        $articlePosts    = $this->articleService->getPublishedArticlesBySlug( $articleSlugs );

        foreach ( $articlePosts as $articleSlug => $article ) {
            if ( ! is_string( $articleSlug ) || $articleSlug === '' ) {
                continue;
            }

            $articlePreviews[$articleSlug] = [
                'title'   => $this->asString( $article->title ),
                'excerpt' => $this->asString( $article->excerpt ) !== ''
                    ? $this->asString( $article->excerpt )
                    : Str::limit( strip_tags( $this->asString( $article->content ) ), 140 ),
                'url' => route( 'articles.show', $article ),
            ];
        }

        return $articlePreviews;
    }

    private function routeIfExists( string $name, string $fallback ): string
    {
        if ( ! Route::has( $name ) ) {
            return $fallback;
        }

        return route( $name );
    }

    private function asString( mixed $value ): string
    {
        if ( is_scalar( $value ) ) {
            return (string) $value;
        }

        return '';
    }
}
