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
        Schema::create( 'data_transfers', function ( Blueprint $table ): void {
            $table->id();
            $table->string( 'type', 20 );
            $table->string( 'resource', 100 );
            $table->foreignId( 'status_id' )->constrained( 'statuses' );
            $table->string( 'disk', 32 )->default( 'local' );
            $table->string( 'path' );
            $table->string( 'original_filename' )->nullable();
            $table->string( 'handler' );
            $table->uuid( 'initiated_by' )->nullable();
            $table->json( 'properties' )->nullable();
            $table->timestamp( 'started_at' )->nullable();
            $table->timestamp( 'completed_at' )->nullable();
            $table->timestamp( 'failed_at' )->nullable();
            $table->text( 'error_message' )->nullable();
            $table->timestamps();

            $table->index( ['type', 'status_id'], 'data_transfers_type_status_index' );
            $table->index( 'resource', 'data_transfers_resource_index' );
            $table->index( 'initiated_by', 'data_transfers_initiated_by_index' );
            $table->index( ['type', 'resource', 'status_id', 'created_at'], 'data_transfers_type_resource_status_created_at_index' );
        } );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists( 'data_transfers' );
    }
};
