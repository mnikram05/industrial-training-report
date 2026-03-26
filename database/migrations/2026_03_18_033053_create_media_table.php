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
        Schema::create( 'media', function ( Blueprint $table ) {
            $table->bigIncrements( 'id' );

            $table->string( 'name' );
            $table->string( 'file_name' );
            $table->string( 'mime_type' )->nullable();
            $table->string( 'path' );
            $table->string( 'disk' )->default( 'public' );
            $table->unsignedBigInteger( 'size' )->default( 0 );
            $table->string( 'collection' )->nullable()->comment( 'Grouping: images, documents, etc.' );
            $table->text( 'alt' )->nullable();

            $table->timestamp( 'created_at' )->nullable();
            $table->foreignUuid( 'created_by' )->nullable()->constrained( 'users' )->nullOnDelete();

            $table->timestamp( 'updated_at' )->nullable();
            $table->foreignUuid( 'updated_by' )->nullable()->constrained( 'users' )->nullOnDelete();

            $table->timestamp( 'deleted_at' )->nullable();
            $table->foreignUuid( 'deleted_by' )->nullable()->constrained( 'users' )->nullOnDelete();
        } );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists( 'media' );
    }
};
