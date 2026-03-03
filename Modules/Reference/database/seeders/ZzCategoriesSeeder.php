<?php

declare(strict_types=1);

namespace Modules\Reference\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Reference\Models\Category;

class ZzCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $file     = fopen( public_path( 'documents/senarai-kategori.csv' ), 'r' );
        $category = Category::pluck( 'id', 'name_my' );

        while ( ! feof( $file ) ) {
            $data = fgetcsv( $file );
            if ( isset( $data[1] ) ) {
                $categories = Category::firstOrCreate( [
                    'name_my' => $data[1],
                    'name_en' => $data[0],
                ] );
            }

            echo '.';

            // dd($see->id);
            if ( $data[2] != 'Kosong' ) {
                $see = Category::where( 'name_my', $data[1] )->first();
                Category::firstOrCreate( [
                    'parent_id' => $see->id,
                    'name_my'   => $data[2],
                    'name_en'   => $data[3],
                ] );
            }
            echo '-';
        }

        fclose( $file );
    }

    protected function seedStatus( array $data, ?int $parentId = null ): void
    {
        $category = Category::updateOrCreate(
            [
                'id' => $data['id'],
            ],
            [
                'parent_id' => $parentId,
                'name_my'   => $data['name'],
            ]
        );

        if ( isset( $data['child'] ) ) {
            foreach ( $data['child'] as $child ) {
                $this->seedStatus( $child, $category->id );
            }
        }
    }
}
