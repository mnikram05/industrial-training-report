<?php

declare(strict_types=1);

namespace Modules\Reference\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Reference\Models\Menu;

class MenusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Parent menus
        $cms = Menu::updateOrCreate(
            ['slug' => 'cms'],
            [
                'title_en'  => 'CMS',
                'title_my'  => 'CMS',
                'url'       => '/',
                'slug'      => 'cms',
                'sort'      => 1,
                'status_id' => 1,
            ],
        );

        $references = Menu::updateOrCreate(
            ['slug' => 'references'],
            [
                'title_en'  => 'References',
                'title_my'  => 'Rujukan',
                'url'       => '/reference',
                'slug'      => 'references',
                'sort'      => 2,
                'status_id' => 1,
            ],
        );

        // CMS submenus
        $cmsMenus = [
            [
                'title_en' => 'Dashboard',
                'title_my' => 'Papan Pemuka',
                'url'      => '/dashboard',
                'slug'     => 'dashboard',
                'sort'     => 1,
            ],
            [
                'title_en' => 'Admin Dashboard',
                'title_my' => 'Papan Pemuka Admin',
                'url'      => '/admin/dashboard',
                'slug'     => 'admin-dashboard',
                'sort'     => 2,
            ],
            [
                'title_en' => 'Articles',
                'title_my' => 'Artikel',
                'url'      => '/articles',
                'slug'     => 'articles',
                'sort'     => 3,
            ],
            [
                'title_en' => 'Landings',
                'title_my' => 'Landings',
                'url'      => '/landings',
                'slug'     => 'landings',
                'sort'     => 4,
            ],
            [
                'title_en' => 'Statuses',
                'title_my' => 'Status',
                'url'      => '/statuses',
                'slug'     => 'statuses',
                'sort'     => 5,
            ],
            [
                'title_en' => 'Users',
                'title_my' => 'Pengguna',
                'url'      => '/users',
                'slug'     => 'users',
                'sort'     => 6,
            ],
            [
                'title_en' => 'Roles',
                'title_my' => 'Peranan',
                'url'      => '/roles',
                'slug'     => 'roles',
                'sort'     => 7,
            ],
            [
                'title_en' => 'Activity Logs',
                'title_my' => 'Log Aktiviti',
                'url'      => '/activity-logs',
                'slug'     => 'activity-logs',
                'sort'     => 8,
            ],
        ];

        foreach ( $cmsMenus as $menu ) {
            Menu::updateOrCreate(
                ['slug' => $menu['slug']],
                array_merge( $menu, [
                    'parent_id' => $cms->id,
                    'status_id' => 1,
                ] ),
            );
        }

        // References submenus
        $referenceMenus = [
            [
                'title_en' => 'States',
                'title_my' => 'Negeri',
                'url'      => '/reference/states',
                'slug'     => 'states',
                'sort'     => 1,
            ],
            [
                'title_en' => 'Parliaments',
                'title_my' => 'Parlimen',
                'url'      => '/reference/parliaments',
                'slug'     => 'parliaments',
                'sort'     => 2,
            ],
            [
                'title_en' => 'DUNs',
                'title_my' => 'DUN',
                'url'      => '/reference/duns',
                'slug'     => 'duns',
                'sort'     => 3,
            ],
            [
                'title_en' => 'Districts',
                'title_my' => 'Daerah',
                'url'      => '/reference/districts',
                'slug'     => 'districts',
                'sort'     => 4,
            ],
            [
                'title_en' => 'Data References',
                'title_my' => 'Rujukan Data',
                'url'      => '/reference/data-references',
                'slug'     => 'data-references',
                'sort'     => 5,
            ],
            [
                'title_en' => 'Menus',
                'title_my' => 'Menu',
                'url'      => '/reference/menus',
                'slug'     => 'menus',
                'sort'     => 6,
            ],
        ];

        foreach ( $referenceMenus as $menu ) {
            Menu::updateOrCreate(
                ['slug' => $menu['slug']],
                array_merge( $menu, [
                    'parent_id' => $references->id,
                    'status_id' => 1,
                ] ),
            );
        }
    }
}
