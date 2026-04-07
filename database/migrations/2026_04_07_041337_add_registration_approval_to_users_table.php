<?php

declare(strict_types=1);

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table( 'users', function ( Blueprint $table ): void {
            $table->timestamp( 'approved_at' )->nullable()->after( 'email_verified_at' );
            $table->string( 'requested_role', 32 )->nullable()->after( 'approved_at' );
        } );

        DB::table( 'users' )->whereNull( 'approved_at' )->update( ['approved_at' => now()] );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table( 'users', function ( Blueprint $table ): void {
            $table->dropColumn( ['approved_at', 'requested_role'] );
        } );
    }
};
