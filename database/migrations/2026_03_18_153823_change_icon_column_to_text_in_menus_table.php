<?php

declare(strict_types=1);

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
        Schema::table( 'menus', function ( Blueprint $table ) {
            $table->text( 'icon' )->nullable()->default( null )->change();
        } );
    }

    public function down(): void
    {
        Schema::table( 'menus', function ( Blueprint $table ) {
            $table->string( 'icon' )->default( '1' )->change();
        } );
    }
};
