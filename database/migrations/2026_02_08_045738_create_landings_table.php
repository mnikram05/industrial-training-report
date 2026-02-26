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
        Schema::create( 'landings', function ( Blueprint $table ): void {
            $table->id();
            $table->string( 'slug' )->unique();
            $table->longText( 'content' )->nullable();
            $table->foreignId( 'status_id' )->constrained( 'statuses' );
            $table->timestamps();

            $table->index( 'status_id' );
            $table->index( 'updated_at' );
        } );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists( 'landings' );
    }
};
