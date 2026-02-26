<?php

declare(strict_types=1);

namespace App\Modules\Landing\Actions;

use App\Modules\Landing\Models\Landing;
use App\Modules\Landing\Enums\LandingStatusEnum;
use App\Modules\Landing\Requests\LandingRequest;
use App\Modules\Landing\Services\LandingService;

class PrepareLandingInputAction
{
    public function __construct(
        private ApplyLandingUploadsAction $applyLandingUploadsAction,
        private LandingService $landingService,
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function handle( LandingRequest $request, ?Landing $landing = null ): array
    {
        $data = $request->validated();

        $titleValue = $data['title'] ?? null;
        $title      = is_scalar( $titleValue ) ? trim( (string) $titleValue ) : '';
        unset( $data['title'] );

        $rawContent = $data['content'] ?? [];
        $content    = is_array( $rawContent ) ? $rawContent : [];

        if ( $title !== '' && ! $this->hasHeroTitle( $content ) ) {
            $heroSection = $content['hero'] ?? [];

            if ( ! is_array( $heroSection ) ) {
                $heroSection = [];
            }

            $heroSection['title'] = [
                'en' => $title,
                'ms' => $title,
            ];
            $content['hero'] = $heroSection;
        }

        if ( ! isset( $data['status_id'] ) || ! is_numeric( $data['status_id'] ) ) {
            $data['status_id'] = $request->boolean( 'is_published' )
                ? LandingStatusEnum::Published->id()
                : LandingStatusEnum::Draft->id();
        }

        unset( $data['is_published'] );

        $normalizedContent = $this->applyLandingUploadsAction->handle(
            $request,
            $content,
            $landing,
        );
        $data['content'] = $this->landingService->normalizeMultilingualContent( $normalizedContent );

        return $data;
    }

    /**
     * @param  array<string|int, mixed>  $content
     */
    private function hasHeroTitle( array $content ): bool
    {
        $heroTitle = data_get( $content, 'hero.title' );

        if ( is_array( $heroTitle ) ) {
            $englishTitle = is_scalar( $heroTitle['en'] ?? null ) ? trim( (string) $heroTitle['en'] ) : '';
            $malayTitle   = is_scalar( $heroTitle['ms'] ?? null ) ? trim( (string) $heroTitle['ms'] ) : '';

            return $englishTitle !== '' || $malayTitle !== '';
        }

        return is_scalar( $heroTitle ) && trim( (string) $heroTitle ) !== '';
    }
}
