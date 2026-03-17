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
    Schema::table('portal_menus', function (Blueprint $table) {
        // Modify column type dulu
        $table->unsignedBigInteger('type_id')->nullable()->change();
        $table->unsignedBigInteger('status_id')->nullable()->change();
    });

    Schema::table('portal_menus', function (Blueprint $table) {
        // Tambah foreign key constraint berasingan
        $table->foreign('type_id')->references('id')->on('zz_data_references');
        $table->foreign('status_id')->references('id')->on('zz_data_references');
    });
}

public function down(): void
{
    Schema::table('portal_menus', function (Blueprint $table) {
        $table->dropForeign(['type_id']);
        $table->dropForeign(['status_id']);

        $table->unsignedBigInteger('type_id')->nullable(false)->change();
        $table->unsignedBigInteger('status_id')->nullable(false)->change();
    });
}
};
