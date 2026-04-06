<?php

declare(strict_types=1);

namespace Modules\Reference\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Reference\Models\DataReference;

class ZzDataReferencesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $file = fopen( module_path( 'Reference','resources/documents/Data_Reference.csv' ), 'r' );
        // dd( $file );

        while (!feof($file)) {
        $data = fgetcsv($file);

        // Guard: skip if fgetcsv returns false or row is too short
        if ($data === false || count($data) < 2) {
            continue;
        }

        $categories = DataReference::firstOrCreate([
            'label_ms' => $data[0],
            'label_en' => $data[1],
        ]);

        echo '.';

        // Guard: ensure index 2 exists before checking its value
        if (isset($data[2]) && !in_array($data[2], ['Kosong', 'kosong', 'KOSONG'])) {
            $see = DataReference::where('label_ms', $data[0])->first();

            if ($see && isset($data[3])) {
                DataReference::firstOrCreate([
                    'parent_id' => $see->id,
                    'label_ms'  => $data[2],
                    'label_en'  => $data[3],
                ]);
            }
        }

        echo '-';
    }

    fclose($file);     

    }
}