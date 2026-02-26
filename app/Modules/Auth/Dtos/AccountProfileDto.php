<?php

declare(strict_types=1);

namespace App\Modules\Auth\Dtos;

final class AccountProfileDto
{
    public function __construct(
        public readonly string $name,
        public readonly string $email,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray( array $data ): self
    {
        $nameValue  = $data['name'] ?? '';
        $emailValue = $data['email'] ?? '';

        return new self(
            name: is_scalar( $nameValue ) ? (string) $nameValue : '',
            email: is_scalar( $emailValue ) ? (string) $emailValue : '',
        );
    }
}
