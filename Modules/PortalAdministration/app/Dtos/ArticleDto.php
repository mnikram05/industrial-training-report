<?php

declare(strict_types=1);

namespace Modules\PortalAdministration\Dtos;

use Modules\PortalAdministration\Enums\ArticleStatusEnum;

final class ArticleDto
{
    public function __construct(
        public readonly string $title,
        public readonly ?string $slug,
        public readonly ?string $excerpt,
        public readonly ?string $content,
        public readonly ?int $statusId,
        public readonly ?string $publishedAt,
        public readonly ?int $menuTypeId = null,
        public readonly ?int $menuId = null,
        public readonly ?string $titleMy = null,
        public readonly ?string $titleEn = null,
        public readonly ?int $documentTypeId = null,
        public readonly ?string $filePath = null,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray( array $data ): self
    {
        $titleValue       = $data['title'] ?? '';
        $slugValue        = $data['slug'] ?? null;
        $excerptValue     = $data['excerpt'] ?? null;
        $contentValue     = $data['content'] ?? null;
        $statusIdValue    = $data['status_id'] ?? null;
        $statusValue      = $data['status'] ?? null;
        $publishedAtValue = $data['published_at'] ?? null;

        $title   = is_scalar( $titleValue ) ? (string) $titleValue : '';
        $slug    = is_scalar( $slugValue ) ? (string) $slugValue : null;
        $excerpt = is_scalar( $excerptValue ) ? (string) $excerptValue : null;
        $content = is_scalar( $contentValue ) ? (string) $contentValue : null;

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

        $menuTypeId     = isset( $data['menu_type_id'] ) && is_numeric( $data['menu_type_id'] ) ? (int) $data['menu_type_id'] : null;
        $menuId         = isset( $data['menu_id'] ) && is_numeric( $data['menu_id'] ) ? (int) $data['menu_id'] : null;
        $titleMy        = isset( $data['title_ms'] ) && is_scalar( $data['title_ms'] ) ? (string) $data['title_ms'] : null;
        $titleEn        = isset( $data['title_en'] ) && is_scalar( $data['title_en'] ) ? (string) $data['title_en'] : null;
        $documentTypeId = isset( $data['document_type_id'] ) && is_numeric( $data['document_type_id'] ) ? (int) $data['document_type_id'] : null;
        $filePath       = isset( $data['file_path'] ) && is_scalar( $data['file_path'] ) ? (string) $data['file_path'] : null;

        return new self(
            title: $title,
            slug: $slug,
            excerpt: $excerpt,
            content: $content,
            statusId: $statusId,
            publishedAt: $publishedAt,
            menuTypeId: $menuTypeId,
            menuId: $menuId,
            titleMy: $titleMy,
            titleEn: $titleEn,
            documentTypeId: $documentTypeId,
            filePath: $filePath,
        );
    }

    public function statusIdOrDefault(): int
    {
        return $this->statusId ?? ArticleStatusEnum::default()->id();
    }
}
