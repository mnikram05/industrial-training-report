<?php

declare(strict_types=1);

namespace App\Modules\Auth\Dtos;

final class RegisterUserDto
{
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly string $password,
        public readonly string $requestedRole,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray( array $data ): self
    {
        $nameValue          = $data['name'] ?? '';
        $emailValue         = $data['email'] ?? '';
        $passwordValue      = $data['password'] ?? '';
        $requestedRoleValue = $data['requested_role'] ?? '';

        return new self(
            name: is_scalar( $nameValue ) ? (string) $nameValue : '',
            email: is_scalar( $emailValue ) ? (string) $emailValue : '',
            password: is_scalar( $passwordValue ) ? (string) $passwordValue : '',
            requestedRole: is_scalar( $requestedRoleValue ) ? (string) $requestedRoleValue : '',
        );
    }
}
