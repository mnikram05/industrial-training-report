<?php

declare(strict_types=1);

namespace App\Modules\Status\Dtos;

final class StatusDto
{
    public function __construct(
        public readonly string $type,
        public readonly string $key,
        public readonly ?int $parentId,
        public readonly string $nameEn,
        public readonly string $nameMs,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray( array $data ): self
    {
        $typeValue     = $data['type'] ?? '';
        $keyValue      = $data['key'] ?? '';
        $parentIdValue = $data['parent_id'] ?? null;
        $nameEnValue   = $data['name_en'] ?? '';
        $nameMsValue   = $data['name_ms'] ?? '';

        return new self(
            type: is_scalar( $typeValue ) ? (string) $typeValue : '',
            key: is_scalar( $keyValue ) ? (string) $keyValue : '',
            parentId: is_numeric( $parentIdValue ) ? (int) $parentIdValue : null,
            nameEn: is_scalar( $nameEnValue ) ? (string) $nameEnValue : '',
            nameMs: is_scalar( $nameMsValue ) ? (string) $nameMsValue : '',
        );
    }
}
