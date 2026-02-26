<?php

declare(strict_types=1);

namespace App\Modules\User\Imports;

use Illuminate\Support\Str;
use App\Contracts\Importable;
use App\Modules\User\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\LazyCollection;
use App\Support\Import\Concerns\InteractsWithXlsxRows;

class UserImport implements Importable
{
    use InteractsWithXlsxRows;

    private const CHUNK_SIZE = 1_000;

    public function import( string $filePath, string|int|null $initiatedBy = null ): void
    {
        DB::disableQueryLog();

        $this->rows( $filePath )
            ->chunk( self::CHUNK_SIZE )
            ->each( function ( LazyCollection $chunk ): void {
                $usersByEmail     = [];
                $passwordsByEmail = [];
                $now              = now();

                foreach ( $chunk as $row ) {
                    $name  = $this->value( $row, 'name' );
                    $email = $this->value( $row, 'email' );

                    if ( $name === null || $email === null ) {
                        continue;
                    }

                    $usersByEmail[$email] = [
                        'id'         => (string) Str::uuid(),
                        'name'       => $name,
                        'email'      => $email,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];

                    $passwordsByEmail[$email] = $this->value( $row, 'password' ) ?? 'password';
                }

                if ( $usersByEmail === [] ) {
                    return;
                }

                User::query()->upsert(
                    array_values( $usersByEmail ),
                    ['email'],
                    ['name', 'updated_at'],
                );

                $existingUsers = User::query()
                    ->whereIn( 'email', array_keys( $passwordsByEmail ) )
                    ->pluck( 'id', 'email' );

                $passwordRows = [];

                foreach ( $existingUsers as $email => $userId ) {
                    if ( ! isset( $passwordsByEmail[$email] ) ) {
                        continue;
                    }

                    $passwordRows[] = [
                        'user_id'    => $userId,
                        'password'   => Hash::make( $passwordsByEmail[$email] ),
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];
                }

                if ( $passwordRows === [] ) {
                    return;
                }

                DB::table( 'passwords' )->upsert(
                    $passwordRows,
                    ['user_id'],
                    ['password', 'updated_at'],
                );
            } );
    }
}
