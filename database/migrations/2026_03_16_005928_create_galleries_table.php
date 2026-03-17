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
        Schema::create('galleries', function (Blueprint $table) {
            $table->bigIncrements( 'id' );
            $table->foreignId('type_media_id')->nullable()->constrained('zz_data_references')->nullOnDelete();
            $table->foreignId('display_status_id')->nullable()->constrained('zz_data_references')->nullOnDelete();
            $table->timestamp( 'start_date' )->nullable();
            $table->timestamp( 'end_date' )->nullable();
            $table->string( 'title_my', 255 )->nullable();
            $table->string( 'title_en', 255 )->nullable();
            $table->integer('is_attactment')->nullable()->default(0)->comment('1 = Attach, 0 = Not Attach');        
            $table->string( 'url', 255 )->nullable();
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
        Schema::dropIfExists('galleries');
    }
};
