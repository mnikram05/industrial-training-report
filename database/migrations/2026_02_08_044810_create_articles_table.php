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
        Schema::create( 'articles', function ( Blueprint $table ): void {
            $table->id();
            $table->foreignUuid( 'user_id' )->constrained( 'users' )->cascadeOnDelete();
            $table->string( 'title' );
            $table->string( 'slug' )->unique();
            $table->text( 'excerpt' )->nullable();
            $table->longText( 'content' );
            $table->foreignId( 'status_id' )->constrained( 'statuses' );
            $table->timestamp( 'published_at' )->nullable();
            $table->timestamps();

            $table->index( ['status_id', 'published_at'] );
            $table->index( 'title' );
            $table->index( 'updated_at' );
        } );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists( 'articles' );
    }
};
