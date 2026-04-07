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
        $this->call( \Modules\PortalAdministration\Database\Seeders\PortalAdministrationDatabaseSeeder::class );

        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            ['name' => 'Admin User', 'email_verified_at' => now(), 'approved_at' => now()],
        );
        $admin->storePassword( 'password' );
        $admin->assignRole( RoleNameConstants::ADMIN );

        $editor = User::firstOrCreate(
            ['email' => 'editor@example.com'],
            ['name' => 'Editor User', 'email_verified_at' => now(), 'approved_at' => now()],
        );
        $editor->storePassword( 'password' );
        $editor->assignRole( RoleNameConstants::EDITOR );

        $viewer = User::firstOrCreate(
            ['email' => 'viewer@example.com'],
            ['name' => 'Viewer User', 'email_verified_at' => now(), 'approved_at' => now()],
        );
        $viewer->storePassword( 'password' );
        $viewer->assignRole( RoleNameConstants::VIEWER );
    }
}
