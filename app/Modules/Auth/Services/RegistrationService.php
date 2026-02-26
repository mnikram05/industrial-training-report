<?php

declare(strict_types=1);

namespace App\Modules\Auth\Services;

use App\Modules\User\Models\User;
use Spatie\Permission\Models\Role;
use App\Modules\Auth\Dtos\RegisterUserDto;
use App\Modules\Role\Constants\RoleNameConstants;
use App\Support\Activity\Concerns\LogsModuleCrudActivity;

class RegistrationService
{
    use LogsModuleCrudActivity;

    private const LOG_NAME = 'auth';

    private const RESOURCE_LABEL = 'User';

    public function register( RegisterUserDto $data ): User
    {
        $connection = User::query()->getConnection();

        /** @var User $user */
        $user = $connection->transaction( function () use ( $data ): User {
            $user = User::query()->create( [
                'name'  => $data->name,
                'email' => $data->email,
            ] );

            $user->storePassword( $data->password );
            $viewerRole = Role::findOrCreate( RoleNameConstants::VIEWER, 'web' );
            $user->syncRoles( [$viewerRole->name] );

            return $user;
        } );

        $this->logCreateAction( self::LOG_NAME, self::RESOURCE_LABEL, $user, $user );

        return $user;
    }
}
