<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivityLogTable extends Migration
{
    public function up(): void
    {
        $databaseConnection = config( 'activitylog.database_connection' );
        $tableName          = config( 'activitylog.table_name' );

        assert( is_null( $databaseConnection ) || is_string( $databaseConnection ) );
        assert( is_string( $tableName ) );

        Schema::connection( $databaseConnection )->create( $tableName, function ( Blueprint $table ): void {
            $table->bigIncrements( 'id' );
            $table->string( 'log_name' )->nullable();
            $table->text( 'description' );
            $table->nullableUuidMorphs( 'subject', 'subject' );
            $table->string( 'event' )->nullable();
            $table->nullableUuidMorphs( 'causer', 'causer' );
            $table->json( 'properties' )->nullable();
            $table->uuid( 'batch_uuid' )->nullable();
            $table->timestamps();
            $table->index( 'log_name' );
            $table->index( ['event', 'created_at'] );
            $table->index( 'created_at' );
        } );
    }

    public function down(): void
    {
        $databaseConnection = config( 'activitylog.database_connection' );
        $tableName          = config( 'activitylog.table_name' );

        assert( is_null( $databaseConnection ) || is_string( $databaseConnection ) );
        assert( is_string( $tableName ) );

        Schema::connection( $databaseConnection )->dropIfExists( $tableName );
    }
}
