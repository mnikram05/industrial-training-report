<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Modules\User\Models\User;
use App\Modules\Role\Constants\RoleNameConstants;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call( RoleAndPermissionSeeder::class );
        $this->call( StatusSeeder::class );
        $this->call( LandingSeeder::class );

        User::factory()->create( [
            'name'  => 'Admin User',
            'email' => 'admin@example.com',
        ] )->assignRole( RoleNameConstants::ADMIN );

        User::factory()->create( [
            'name'  => 'Editor User',
            'email' => 'editor@example.com',
        ] )->assignRole( RoleNameConstants::EDITOR );

        User::factory()->create( [
            'name'  => 'Viewer User',
            'email' => 'viewer@example.com',
        ] )->assignRole( RoleNameConstants::VIEWER );
    }
}
