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
            ['label_my' => 'Status', 'parent_id' => null],
            ['label_en' => 'Status', 'status' => true],
        );

        foreach ( [
            ['label_my' => 'Draf', 'label_en' => 'Draft'],
            ['label_my' => 'Menunggu Semakan', 'label_en' => 'Awaiting Review'],
            ['label_my' => 'Diluluskan', 'label_en' => 'Approved'],
            ['label_my' => 'Ditolak', 'label_en' => 'Rejected'],
            ['label_my' => 'Tidak Diluluskan', 'label_en' => 'Not Approved'],
        ] as $child ) {
            DataReference::query()->updateOrCreate(
                ['label_my' => $child['label_my'], 'parent_id' => $status->id],
                ['label_en' => $child['label_en'], 'status' => true],
            );
        }

        // Jenis Menu
        $menuType = DataReference::query()->updateOrCreate(
            ['label_my' => 'Jenis Menu', 'parent_id' => null],
            ['label_en' => 'Menu Type', 'status' => true],
        );

        foreach ( [
            ['label_my' => 'Atas', 'label_en' => 'Top'],
            ['label_my' => 'Bawah', 'label_en' => 'Down'],
            ['label_my' => 'Lain-lain', 'label_en' => 'Others'],
            ['label_my' => 'Navigasi Cepat', 'label_en' => 'Quick Navigation'],
        ] as $child ) {
            DataReference::query()->updateOrCreate(
                ['label_my' => $child['label_my'], 'parent_id' => $menuType->id],
                ['label_en' => $child['label_en'], 'status' => true],
            );
        }

        // Jenis Dokumen
        $docType = DataReference::query()->updateOrCreate(
            ['label_my' => 'Jenis Dokumen', 'parent_id' => null],
            ['label_en' => 'Document Type', 'status' => true],
        );

        foreach ( [
            ['label_my' => 'Kontent', 'label_en' => 'Content'],
            ['label_my' => 'Dokumen', 'label_en' => 'Document'],
        ] as $child ) {
            DataReference::query()->updateOrCreate(
                ['label_my' => $child['label_my'], 'parent_id' => $docType->id],
                ['label_en' => $child['label_en'], 'status' => true],
            );
        }

        // Jenis Media
        $mediaType = DataReference::query()->updateOrCreate(
            ['label_my' => 'Jenis Media', 'parent_id' => null],
            ['label_en' => 'Media Type', 'status' => true],
        );

        DataReference::query()->updateOrCreate(
            ['label_my' => 'Gambar', 'parent_id' => $mediaType->id],
            ['label_en' => 'Image', 'status' => true],
        );
    }
}
