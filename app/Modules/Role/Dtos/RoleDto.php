<?php

declare(strict_types=1);

namespace App\Modules\Role\Dtos;

final class RoleDto
{
    public function __construct(
        public readonly string $name,
        /** @var array<int, string> */
        public readonly array $permissions,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray( array $data ): self
    {
        $name                  = $data['name'] ?? '';
        $permissions           = $data['permissions'] ?? [];
        $normalizedPermissions = [];

        if ( is_array( $permissions ) ) {
            foreach ( $permissions as $permission ) {
                if ( is_scalar( $permission ) ) {
                    $normalizedPermissions[] = (string) $permission;
                }
            }
        }

        return new self(
            name: is_scalar( $name ) ? (string) $name : '',
            permissions: array_values( array_unique( $normalizedPermissions ) ),
        );
    }
}
