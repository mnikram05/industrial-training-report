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
        Schema::table( 'users', function ( Blueprint $table ) {
            $table->unsignedInteger( 'type_user_id' )->nullable()->after( 'id' );
            $table->string( 'nric', 12 )->nullable()->after( 'name' );
            $table->string( 'staff_number', 255 )->nullable()->after( 'nric' );
            $table->string( 'phone', 12 )->nullable()->after( 'staff_number' );
            $table->unsignedInteger( 'department_id' )->nullable()->after( 'phone' );
            $table->unsignedInteger( 'grade_position_id' )->nullable()->after( 'department_id' );
            $table->string( 'position' )->nullable()->after( 'grade_position_id' );
            $table->unsignedBigInteger( 'state_id' )->nullable()->after( 'position' );
            $table->unsignedBigInteger( 'district_id' )->nullable()->after( 'state_id' );
            $table->unsignedInteger( 'status_id' )->nullable()->after( 'district_id' );
            $table->foreignUuid( 'deleted_by' )->nullable()->after( 'updated_at' );
            $table->softDeletes()->after( 'deleted_by' );
        } );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table( 'users', function ( Blueprint $table ) {
            $table->dropSoftDeletes();
            $table->dropColumn( [
                'type_user_id',
                'nric',
                'staff_number',
                'phone',
                'department_id',
                'grade_position_id',
                'position',
                'state_id',
                'district_id',
                'status_id',
                'deleted_by',
            ] );
        } );
    }
};
