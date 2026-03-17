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
        Schema::create('portal_menus', function (Blueprint $table) {
            $table->bigIncrements( 'id' );
            $table->foreignId( 'parent_id' )->nullable()->constrained( 'portal_menus' )->nullOnDelete();
            $table->string( 'title_my', 255 )->nullable();
            $table->string( 'title_en', 255 )->nullable();
            $table->integer( 'type_id' )->nullable();
            $table->integer( 'status_id' )->nullable()->default( 1 )->comment( '1 = Active, 0 = Inactive' );
            $table->string( 'icon', 255 )->nullable()->default( 1 )->comment( '1 = Active, 0 = Inactive' );
            $table->string( 'sort', 255 )->nullable();
            $table->string( 'url', 255 )->nullable();
            $table->string( 'slug', 255 )->nullable();
            $table->timestamp( 'created_at' )->nullable();
            $table->foreignUuid( 'created_by' )->nullable()->constrained( 'users' )->nullOnDelete();
            $table->timestamp( 'updated_at' )->nullable();
            $table->foreignUuid( 'updated_by' )->nullable()->constrained( 'users' )->nullOnDelete();
            $table->timestamp( 'deleted_at' )->nullable();
            $table->foreignUuid( 'deleted_by' )->nullable()->constrained( 'users' )->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('portal_menus');
    }
};
