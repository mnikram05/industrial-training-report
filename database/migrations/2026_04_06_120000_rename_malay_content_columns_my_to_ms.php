<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Standard ISO 639-1 for Malay is "ms". Column suffixes use _ms (not _my).
     */
    public function up(): void
    {
        if (Schema::hasTable('zz_data_references') && Schema::hasColumn('zz_data_references', 'label_my')) {
            Schema::table('zz_data_references', function (Blueprint $table): void {
                $table->renameColumn('label_my', 'label_ms');
            });
        }

        if (Schema::hasTable('portal_menus') && Schema::hasColumn('portal_menus', 'title_my')) {
            Schema::table('portal_menus', function (Blueprint $table): void {
                $table->renameColumn('title_my', 'title_ms');
            });
        }

        if (Schema::hasTable('portal_articles')) {
            if (Schema::hasColumn('portal_articles', 'title_my')) {
                Schema::table('portal_articles', function (Blueprint $table): void {
                    $table->renameColumn('title_my', 'title_ms');
                });
            }
            if (Schema::hasColumn('portal_articles', 'content_my')) {
                Schema::table('portal_articles', function (Blueprint $table): void {
                    $table->renameColumn('content_my', 'content_ms');
                });
            }
        }

        if (Schema::hasTable('galleries') && Schema::hasColumn('galleries', 'title_my')) {
            Schema::table('galleries', function (Blueprint $table): void {
                $table->renameColumn('title_my', 'title_ms');
            });
        }

        if (Schema::hasTable('menus') && Schema::hasColumn('menus', 'title_my')) {
            Schema::table('menus', function (Blueprint $table): void {
                $table->renameColumn('title_my', 'title_ms');
            });
        }

        if (Schema::hasTable('articles') && Schema::hasColumn('articles', 'title_my')) {
            Schema::table('articles', function (Blueprint $table): void {
                $table->renameColumn('title_my', 'title_ms');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('zz_data_references') && Schema::hasColumn('zz_data_references', 'label_ms')) {
            Schema::table('zz_data_references', function (Blueprint $table): void {
                $table->renameColumn('label_ms', 'label_my');
            });
        }

        if (Schema::hasTable('portal_menus') && Schema::hasColumn('portal_menus', 'title_ms')) {
            Schema::table('portal_menus', function (Blueprint $table): void {
                $table->renameColumn('title_ms', 'title_my');
            });
        }

        if (Schema::hasTable('portal_articles')) {
            if (Schema::hasColumn('portal_articles', 'title_ms')) {
                Schema::table('portal_articles', function (Blueprint $table): void {
                    $table->renameColumn('title_ms', 'title_my');
                });
            }
            if (Schema::hasColumn('portal_articles', 'content_ms')) {
                Schema::table('portal_articles', function (Blueprint $table): void {
                    $table->renameColumn('content_ms', 'content_my');
                });
            }
        }

        if (Schema::hasTable('galleries') && Schema::hasColumn('galleries', 'title_ms')) {
            Schema::table('galleries', function (Blueprint $table): void {
                $table->renameColumn('title_ms', 'title_my');
            });
        }

        if (Schema::hasTable('menus') && Schema::hasColumn('menus', 'title_ms')) {
            Schema::table('menus', function (Blueprint $table): void {
                $table->renameColumn('title_ms', 'title_my');
            });
        }

        if (Schema::hasTable('articles') && Schema::hasColumn('articles', 'title_ms')) {
            Schema::table('articles', function (Blueprint $table): void {
                $table->renameColumn('title_ms', 'title_my');
            });
        }
    }
};
