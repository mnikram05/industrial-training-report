<?php

declare(strict_types=1);

namespace Modules\Reference\Database\Seeders;

use Illuminate\Database\Seeder;

class ReferenceDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    // public function run(): void
    // {
    //     // $this->call([]);
    // }

    public function run(): void
    {
        $this->call( [
            ZzStatesSeeder::class,
            ZzDistrictsSeeder::class,
            ZzParliamentsSeeder::class,
            ZzDunsSeeder::class,
            // ZzCategoriesSeeder::class,
        ] );
    }
}
