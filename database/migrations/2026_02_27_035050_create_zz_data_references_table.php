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
        Schema::create( 'zz_data_references', function ( Blueprint $table ) {
            $table->bigIncrements( 'id' );
            $table->foreignId( 'parent_id' )->nullable()->constrained( 'zz_data_references' );

            $table->string( 'label_my' )->nullable();
            $table->string( 'label_en' )->nullable();
            $table->string( 'name' )->nullable();
            $table->integer( 'sort' )->nullable();
            $table->integer( 'status' )->nullable()->default( 1 )->comment( '1 = Active, 0 = Inactive' );

            $table->timestamp( 'created_at' )->nullable();
            // $table->unsignedBigInteger('created_by')->nullable();
            // $table->foreign('created_by')->references('id')->on('users');
            $table->foreignUuid( 'created_by' )->nullable()->constrained( 'users' )->nullOnDelete();

            $table->timestamp( 'updated_at' )->nullable();
            // $table->unsignedBigInteger('updated_by')->nullable();
            // $table->foreign('updated_by')->references('id')->on('users');
            $table->foreignUuid( 'updated_by' )->nullable()->constrained( 'users' )->nullOnDelete();

            $table->timestamp( 'deleted_at' )->nullable();
            // $table->unsignedBigInteger('deleted_by')->nullable();
            // $table->foreign('deleted_by')->references('id')->on('users');
            $table->foreignUuid( 'deleted_by' )->nullable()->constrained( 'users' )->nullOnDelete();
        } );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists( 'zz_data_references' );
    }
};
