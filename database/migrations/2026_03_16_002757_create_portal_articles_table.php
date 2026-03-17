<?php

use Carbon\Traits\Timestamp;
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
        Schema::create('portal_articles', function (Blueprint $table) {
            $table->bigIncrements( 'id' );
            $table->foreignId( 'menu_type_id' )->nullable()->constrained( 'portal_menus' )->nullOnDelete();
            $table->integer( 'type_id' )->nullable()->constrained( 'portal_menus' )->nullOnDelete();
            $table->foreignId('display_status_id')->nullable()->constrained( 'zz_data_references' )->nullOnDelete();
            $table->timestamp( 'start_date' )->nullable();
            $table->timestamp( 'end_date' )->nullable();
            $table->string( 'title_my', 255 )->nullable();
            $table->string( 'title_en', 255 )->nullable();
            $table->foreignId('document_type_id')->nullable()->constrained('zz_data_references')->nullOnDelete();
            $table->timestamp( 'document_date' )->nullable();
            $table->longText('content_my')->nullable();
            $table->longText('content_en')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->foreignUuid( 'created_by' )->nullable()->constrained( 'users' )->nullOnDelete();
            $table->timestamp('updated_at')->nullable();
            $table->foreignUuid( 'updated_by' )->nullable()->constrained( 'users' )->nullOnDelete();
            $table->timestamp('deleted_at')->nullable();   
            $table->foreignUuid( 'deleted_by' )->nullable()->constrained( 'users' )->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('portal_articles');
    }
};
