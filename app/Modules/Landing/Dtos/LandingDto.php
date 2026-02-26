<?php

declare(strict_types=1);

namespace App\Modules\Landing\Dtos;

use App\Modules\Landing\Enums\LandingStatusEnum;

final class LandingDto
{
    public function __construct(
        public readonly ?string $slug,
        /** @var array<string|int, mixed>|null */
        public readonly ?array $content,
        public readonly ?int $statusId,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray( array $data ): self
    {
        $slug          = $data['slug'] ?? null;
        $content       = $data['content'] ?? null;
        $statusIdValue = $data['status_id'] ?? null;
        $publishedFlag = $data['is_published'] ?? null;

        $normalizedContent = is_array( $content ) ? $content : null;
        $statusId          = is_numeric( $statusIdValue )
            ? (int) $statusIdValue
            : null;

        if ( $statusId === null && $publishedFlag !== null ) {
            $isPublished = in_array( $publishedFlag, [true, 1, '1', 'true', 'on'], true );
            $statusId    = $isPublished
                ? LandingStatusEnum::Published->id()
                : LandingStatusEnum::Draft->id();
        }

        return new self(
            slug: is_scalar( $slug ) ? (string) $slug : null,
            content: $normalizedContent,
            statusId: $statusId,
        );
    }

    public function statusIdOrDefault(): int
    {
        return $this->statusId ?? LandingStatusEnum::default()->id();
    }
}
