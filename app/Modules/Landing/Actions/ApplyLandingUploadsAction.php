<?php

declare(strict_types=1);

namespace App\Modules\Landing\Actions;

use Illuminate\Support\Arr;
use Illuminate\Http\UploadedFile;
use App\Modules\Landing\Models\Landing;
use App\Modules\Landing\Requests\LandingRequest;

class ApplyLandingUploadsAction
{
    /**
     * @param  array<string|int, mixed>  $content
     * @return array<string|int, mixed>
     */
    public function handle(
        LandingRequest $request,
        array $content,
        ?Landing $landing = null,
    ): array {
        $baseContent = $landing?->content;

        if ( ! is_array( $baseContent ) ) {
            $baseContent = [];
        }

        /** @var array<string|int, mixed> $content */
        $content = array_replace_recursive( $baseContent, $content );
        $content = $this->storeContentImage( $request, $content, 'content.banner.image', 'banner.image', 'landings/banners' );
        $content = $this->storeContentImage( $request, $content, 'content.about.image', 'about.image', 'landings/about' );
        $content = $this->storeContentImage( $request, $content, 'content.security.image', 'security.image', 'landings/security' );

        $articleFiles = data_get( $request->allFiles(), 'content.articles' );

        if ( is_array( $articleFiles ) ) {
            foreach ( $articleFiles as $index => $articleFileSet ) {
                if ( ! is_array( $articleFileSet ) ) {
                    continue;
                }

                $image = $articleFileSet['image'] ?? null;

                if ( $image instanceof UploadedFile ) {
                    Arr::set( $content, "articles.{$index}.image", $image->store( 'landings/articles', 'public' ) );
                }
            }
        }

        return $content;
    }

    /**
     * @param  array<string|int, mixed>  $content
     * @return array<string|int, mixed>
     */
    private function storeContentImage(
        LandingRequest $request,
        array $content,
        string $inputKey,
        string $contentKey,
        string $directory,
    ): array {
        $file = $request->file( $inputKey );

        if ( $file instanceof UploadedFile ) {
            Arr::set( $content, $contentKey, $file->store( $directory, 'public' ) );
        }

        return $content;
    }
}
