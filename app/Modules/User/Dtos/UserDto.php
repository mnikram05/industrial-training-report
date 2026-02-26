<?php

declare(strict_types=1);

namespace App\Modules\User\Dtos;

final class UserDto
{
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly ?string $password,
        public readonly ?string $role,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function forCreate( array $data ): self
    {
        $name     = $data['name'] ?? '';
        $email    = $data['email'] ?? '';
        $password = $data['password'] ?? null;
        $role     = $data['role'] ?? null;

        return new self(
            name: is_scalar( $name ) ? (string) $name : '',
            email: is_scalar( $email ) ? (string) $email : '',
            password: is_scalar( $password ) ? (string) $password : null,
            role: is_scalar( $role ) ? (string) $role : null,
        );
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public static function forUpdate( array $data ): self
    {
        return self::forCreate( $data );
    }
}
