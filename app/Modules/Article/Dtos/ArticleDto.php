<?php

declare(strict_types=1);

namespace App\Modules\Article\Dtos;

use App\Modules\Article\Enums\ArticleStatusEnum;

final class ArticleDto
{
    public function __construct(
        public readonly string $title,
        public readonly ?string $slug,
        public readonly ?string $excerpt,
        public readonly string $content,
        public readonly ?int $statusId,
        public readonly ?string $publishedAt
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray( array $data ): self
    {
        $titleValue       = $data['title'] ?? '';
        $slugValue        = $data['slug'] ?? null;
        $excerptValue     = $data['excerpt'] ?? null;
        $contentValue     = $data['content'] ?? '';
        $statusIdValue    = $data['status_id'] ?? null;
        $statusValue      = $data['status'] ?? null;
        $publishedAtValue = $data['published_at'] ?? null;

        $title   = is_scalar( $titleValue ) ? (string) $titleValue : '';
        $slug    = is_scalar( $slugValue ) ? (string) $slugValue : null;
        $excerpt = is_scalar( $excerptValue ) ? (string) $excerptValue : null;
        $content = is_scalar( $contentValue ) ? (string) $contentValue : '';

        $statusId = is_numeric( $statusIdValue )
            ? (int) $statusIdValue
            : null;

        if ( $statusId === null && is_scalar( $statusValue ) && is_string( $statusValue ) ) {
            $status = ArticleStatusEnum::tryFrom( $statusValue );

            if ( $status instanceof ArticleStatusEnum ) {
                $statusId = $status->id();
            }
        }

        $publishedAt = is_scalar( $publishedAtValue ) ? (string) $publishedAtValue : null;

        return new self(
            title: $title,
            slug: $slug,
            excerpt: $excerpt,
            content: $content,
            statusId: $statusId,
            publishedAt: $publishedAt,
        );
    }

    public function statusIdOrDefault(): int
    {
        return $this->statusId ?? ArticleStatusEnum::default()->id();
    }
}
