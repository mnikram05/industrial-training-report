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
        Schema::create( 'statuses', function ( Blueprint $table ): void {
            $table->id();
            $table->string( 'type', 40 );
            $table->string( 'key', 40 );
            $table->foreignId( 'parent_id' )->nullable()->constrained( 'statuses' )->nullOnDelete();
            $table->string( 'name_en', 120 );
            $table->string( 'name_ms', 120 );
            $table->timestamps();

            $table->unique( ['type', 'key'] );
            $table->index( 'type' );
            $table->index( 'key' );
            $table->index( 'parent_id' );
        } );

        $now = now();

        $articleParentId = DB::table( 'statuses' )->insertGetId( [
            'type'       => 'module',
            'key'        => 'article',
            'parent_id'  => null,
            'name_en'    => 'Article',
            'name_ms'    => 'Artikel',
            'created_at' => $now,
            'updated_at' => $now,
        ] );

        $landingParentId = DB::table( 'statuses' )->insertGetId( [
            'type'       => 'module',
            'key'        => 'landing',
            'parent_id'  => null,
            'name_en'    => 'Landing',
            'name_ms'    => 'Pendaratan',
            'created_at' => $now,
            'updated_at' => $now,
        ] );

        $dataTransferParentId = DB::table( 'statuses' )->insertGetId( [
            'type'       => 'module',
            'key'        => 'data_transfer',
            'parent_id'  => null,
            'name_en'    => 'Data Transfer',
            'name_ms'    => 'Pemindahan Data',
            'created_at' => $now,
            'updated_at' => $now,
        ] );

        DB::table( 'statuses' )->insert( [
            ['type' => 'article', 'key' => 'draft', 'parent_id' => $articleParentId, 'name_en' => 'Draft', 'name_ms' => 'Draf', 'created_at' => $now, 'updated_at' => $now],
            ['type' => 'article', 'key' => 'published', 'parent_id' => $articleParentId, 'name_en' => 'Published', 'name_ms' => 'Diterbitkan', 'created_at' => $now, 'updated_at' => $now],
            ['type' => 'landing', 'key' => 'draft', 'parent_id' => $landingParentId, 'name_en' => 'Draft', 'name_ms' => 'Draf', 'created_at' => $now, 'updated_at' => $now],
            ['type' => 'landing', 'key' => 'published', 'parent_id' => $landingParentId, 'name_en' => 'Published', 'name_ms' => 'Diterbitkan', 'created_at' => $now, 'updated_at' => $now],
            ['type' => 'data_transfer', 'key' => 'queued', 'parent_id' => $dataTransferParentId, 'name_en' => 'Queued', 'name_ms' => 'Dalam giliran', 'created_at' => $now, 'updated_at' => $now],
            ['type' => 'data_transfer', 'key' => 'running', 'parent_id' => $dataTransferParentId, 'name_en' => 'Running', 'name_ms' => 'Sedang diproses', 'created_at' => $now, 'updated_at' => $now],
            ['type' => 'data_transfer', 'key' => 'completed', 'parent_id' => $dataTransferParentId, 'name_en' => 'Completed', 'name_ms' => 'Selesai', 'created_at' => $now, 'updated_at' => $now],
            ['type' => 'data_transfer', 'key' => 'failed', 'parent_id' => $dataTransferParentId, 'name_en' => 'Failed', 'name_ms' => 'Gagal', 'created_at' => $now, 'updated_at' => $now],
        ] );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists( 'statuses' );
    }
};
