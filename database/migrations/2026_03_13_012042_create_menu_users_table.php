<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create( 'menu_users', function ( Blueprint $table ) {
            $table->foreignId( 'menu_id' )->constrained( 'menus' );
            $table->foreignUuid( 'user_id' )->constrained( 'users' );
        } );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists( 'menu_users' );
    }
};
