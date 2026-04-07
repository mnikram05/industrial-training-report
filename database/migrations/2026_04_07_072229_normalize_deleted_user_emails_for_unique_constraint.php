<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table( 'users' )
            ->whereNotNull( 'deleted_at' )
            ->select( ['id'] )
            ->orderBy( 'id' )
            ->cursor()
            ->each( function ( object $row ): void {
                $id = is_string( $row->id ) ? $row->id : (string) $row->id;

                DB::table( 'users' )
                    ->where( 'id', $id )
                    ->update( ['email' => 'deleted+' . $id . '@example.invalid'] );
            } );
    }

    public function down(): void
    {
        // No-op: original deleted emails are intentionally not restorable.
    }
};
