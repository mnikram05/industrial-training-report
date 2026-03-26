<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        // Drop unique on key first, re-add as composite
        Schema::table( 'portal_settings', function ( Blueprint $table ) {
            $table->dropUnique( ['key'] );
            $table->string( 'page' )->default( 'home' )->after( 'id' );
        } );

        Schema::table( 'portal_settings', function ( Blueprint $table ) {
            $table->unique( ['page', 'key'] );
        } );
    }

    public function down(): void
    {
        Schema::table( 'portal_settings', function ( Blueprint $table ) {
            $table->dropUnique( ['page', 'key'] );
            $table->dropColumn( 'page' );
            $table->unique( 'key' );
        } );
    }
};
