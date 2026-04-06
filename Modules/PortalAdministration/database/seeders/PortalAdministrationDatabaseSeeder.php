<?php

declare(strict_types=1);

namespace Modules\PortalAdministration\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Reference\Models\DataReference;

class PortalAdministrationDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->seedDataReferences();

        $this->call( [
            MenuSeeder::class,
            ArticleSeeder::class,
            MediaSeeder::class,
            PortalSettingSeeder::class,
        ] );
    }

    private function seedDataReferences(): void
    {
        // Status
        $status = DataReference::query()->updateOrCreate(
            ['label_ms' => 'Status', 'parent_id' => null],
            ['label_en' => 'Status', 'status' => true],
        );

        foreach ( [
            ['label_ms' => 'Draf', 'label_en' => 'Draft'],
            ['label_ms' => 'Menunggu Semakan', 'label_en' => 'Awaiting Review'],
            ['label_ms' => 'Diluluskan', 'label_en' => 'Approved'],
            ['label_ms' => 'Ditolak', 'label_en' => 'Rejected'],
            ['label_ms' => 'Tidak Diluluskan', 'label_en' => 'Not Approved'],
        ] as $child ) {
            DataReference::query()->updateOrCreate(
                ['label_ms' => $child['label_ms'], 'parent_id' => $status->id],
                ['label_en' => $child['label_en'], 'status' => true],
            );
        }

        // Jenis Menu
        $menuType = DataReference::query()->updateOrCreate(
            ['label_ms' => 'Jenis Menu', 'parent_id' => null],
            ['label_en' => 'Menu Type', 'status' => true],
        );

        foreach ( [
            ['label_ms' => 'Atas', 'label_en' => 'Top'],
            ['label_ms' => 'Bawah', 'label_en' => 'Down'],
            ['label_ms' => 'Lain-lain', 'label_en' => 'Others'],
            ['label_ms' => 'Navigasi Cepat', 'label_en' => 'Quick Navigation'],
        ] as $child ) {
            DataReference::query()->updateOrCreate(
                ['label_ms' => $child['label_ms'], 'parent_id' => $menuType->id],
                ['label_en' => $child['label_en'], 'status' => true],
            );
        }

        // Jenis Dokumen
        $docType = DataReference::query()->updateOrCreate(
            ['label_ms' => 'Jenis Dokumen', 'parent_id' => null],
            ['label_en' => 'Document Type', 'status' => true],
        );

        foreach ( [
            ['label_ms' => 'Kontent', 'label_en' => 'Content'],
            ['label_ms' => 'Dokumen', 'label_en' => 'Document'],
        ] as $child ) {
            DataReference::query()->updateOrCreate(
                ['label_ms' => $child['label_ms'], 'parent_id' => $docType->id],
                ['label_en' => $child['label_en'], 'status' => true],
            );
        }

        // Jenis Media
        $mediaType = DataReference::query()->updateOrCreate(
            ['label_ms' => 'Jenis Media', 'parent_id' => null],
            ['label_en' => 'Media Type', 'status' => true],
        );

        DataReference::query()->updateOrCreate(
            ['label_ms' => 'Gambar', 'parent_id' => $mediaType->id],
            ['label_en' => 'Image', 'status' => true],
        );
    }
}
