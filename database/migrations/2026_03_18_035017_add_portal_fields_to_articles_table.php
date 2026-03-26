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
        Schema::table( 'articles', function ( Blueprint $table ) {
            $table->foreignId( 'menu_type_id' )->nullable()->after( 'id' )->constrained( 'menus' )->nullOnDelete();
            $table->foreignId( 'menu_id' )->nullable()->after( 'menu_type_id' )->constrained( 'menus' )->nullOnDelete();
            $table->string( 'title_my' )->nullable()->after( 'menu_id' );
            $table->string( 'title_en' )->nullable()->after( 'title_my' );
            $table->foreignId( 'document_type_id' )->nullable()->after( 'title_en' )->constrained( 'zz_data_references' )->nullOnDelete();
            $table->string( 'file_path' )->nullable()->after( 'content' );
        } );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table( 'articles', function ( Blueprint $table ) {
            $table->dropConstrainedForeignId( 'menu_type_id' );
            $table->dropConstrainedForeignId( 'menu_id' );
            $table->dropColumn( 'title_my' );
            $table->dropColumn( 'title_en' );
            $table->dropConstrainedForeignId( 'document_type_id' );
            $table->dropColumn( 'file_path' );
        } );
    }
};
