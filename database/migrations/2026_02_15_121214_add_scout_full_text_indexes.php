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
        if ( ! $this->supportsFullText() ) {
            return;
        }

        Schema::table( 'users', function ( Blueprint $table ): void {
            $table->fullText( ['name', 'email'], 'users_search_fulltext' );
        } );

        Schema::table( 'articles', function ( Blueprint $table ): void {
            $table->fullText( ['title', 'excerpt', 'content'], 'articles_search_fulltext' );
        } );

        Schema::table( 'landings', function ( Blueprint $table ): void {
            $table->fullText( ['content'], 'landings_search_fulltext' );
        } );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if ( ! $this->supportsFullText() ) {
            return;
        }

        Schema::table( 'users', function ( Blueprint $table ): void {
            $table->dropFullText( 'users_search_fulltext' );
        } );

        Schema::table( 'articles', function ( Blueprint $table ): void {
            $table->dropFullText( 'articles_search_fulltext' );
        } );

        Schema::table( 'landings', function ( Blueprint $table ): void {
            $table->dropFullText( 'landings_search_fulltext' );
        } );
    }

    private function supportsFullText(): bool
    {
        return in_array( Schema::getConnection()->getDriverName(), ['mysql', 'mariadb'], true );
    }
};
