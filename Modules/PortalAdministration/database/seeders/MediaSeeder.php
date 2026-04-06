<?php

declare(strict_types=1);

namespace Modules\PortalAdministration\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\PortalAdministration\Models\Media;
use Modules\PortalAdministration\Support\PortalPublicMediaPaths;

class MediaSeeder extends Seeder
{
    public function run(): void
    {
        foreach (PortalPublicMediaPaths::portalMediaCatalog() as $row) {
            Media::query()->updateOrCreate(
                ['name' => $row['name']],
                [
                    'file_name' => $row['file_name'],
                    'mime_type' => $row['mime_type'],
                    'path' => $row['path'],
                    'disk' => $row['disk'],
                    'size' => $row['size'],
                    'collection' => $row['collection'],
                ],
            );
        }
    }
}
