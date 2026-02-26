<?php

declare(strict_types=1);

namespace App\Modules\User\Services;

use Illuminate\Support\Str;
use App\Modules\User\Models\User;
use App\Modules\User\Dtos\UserDto;
use Spatie\Permission\Models\Role;
use Illuminate\Contracts\Auth\Authenticatable;
use App\Modules\Role\Constants\RoleNameConstants;
use App\Support\Activity\Concerns\LogsModuleCrudActivity;

class UserService
{
    use LogsModuleCrudActivity;

    private const LOG_NAME = 'users';

    private const RESOURCE_LABEL = 'User';

    /**
     * @return array<string, string>
     */
    public function getAssignableRoleOptions(): array
    {
        return Role::query()
            ->orderBy( 'name' )
            ->pluck( 'name', 'name' )
            ->mapWithKeys( static function ( mixed $roleName, int|string $roleKey ): array {
                $resolvedRoleName = is_string( $roleName ) && $roleName !== ''
                    ? $roleName
                    : (string) $roleKey;

                return [
                    $resolvedRoleName => Str::headline( $resolvedRoleName ),
                ];
            } )
            ->all();
    }

    /**
     * @param  array<string, mixed>  $validated
     * @return array<string, mixed>
     */
    public function sanitizeValidatedInput( array $validated, ?Authenticatable $actor = null ): array
    {
        if ( ! $actor instanceof User || ! $actor->hasRole( RoleNameConstants::ADMIN ) ) {
            unset( $validated['role'] );
        }

        return $validated;
    }

    /**
     * @return array<string, string>
     */
    public function getAssignableRoleOptionsFor( ?Authenticatable $actor = null ): array
    {
        if ( ! $actor instanceof User || ! $actor->hasRole( RoleNameConstants::ADMIN ) ) {
            return [];
        }

        return $this->getAssignableRoleOptions();
    }

    /**
     * Create a new user.
     */
    public function createUser( UserDto $data, ?Authenticatable $causer = null ): User
    {
        $user = User::create( [
            'name'  => $data->name,
            'email' => $data->email,
        ] );

        if ( $data->password !== null && $data->password !== '' ) {
            $user->storePassword( $data->password );
        }

        if ( $data->role !== null && $data->role !== '' ) {
            $user->syncRoles( [$data->role] );
        }

        $user = $user->refresh();

        $this->logCreateAction( self::LOG_NAME, self::RESOURCE_LABEL, $causer, $user );

        return $user;
    }

    /**
     * Update an existing user.
     */
    public function updateUser( User $user, UserDto $data, ?Authenticatable $causer = null ): User
    {
        $user->update( [
            'name'  => $data->name,
            'email' => $data->email,
        ] );

        if ( $data->password !== null && $data->password !== '' ) {
            $user->storePassword( $data->password );
        }

        if ( $data->role !== null && $data->role !== '' ) {
            $user->syncRoles( [$data->role] );
        }

        $user = $user->refresh();

        $this->logUpdateAction( self::LOG_NAME, self::RESOURCE_LABEL, $causer, $user );

        return $user;
    }

    /**
     * Delete a user.
     */
    public function deleteUser( User $user, ?Authenticatable $causer = null ): bool
    {
        $deleted = (bool) $user->delete();

        if ( $deleted ) {
            $this->logDeleteAction( self::LOG_NAME, self::RESOURCE_LABEL, $causer, $user );
        }

        return $deleted;
    }
}
