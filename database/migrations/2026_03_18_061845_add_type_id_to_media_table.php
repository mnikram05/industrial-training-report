<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table( 'media', function ( Blueprint $table ) {
            $table->foreignId( 'type_id' )->nullable()->after( 'id' )->constrained( 'zz_data_references' )->nullOnDelete();
        } );
    }

    public function down(): void
    {
        Schema::table( 'media', function ( Blueprint $table ) {
            $table->dropConstrainedForeignId( 'type_id' );
        } );
    }
};
