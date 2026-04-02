<?php

declare(strict_types=1);

namespace Modules\PortalAdministration\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\PortalAdministration\Database\Seeders\Portal\CartaOrganisasiSeeder;
use Modules\PortalAdministration\Database\Seeders\Portal\FungsiBahagianSeeder;
use Modules\PortalAdministration\Database\Seeders\Portal\HalatujuOrganisasiSeeder;
use Modules\PortalAdministration\Database\Seeders\Portal\HeaderFooterSeeder;
use Modules\PortalAdministration\Database\Seeders\Portal\HomeSeeder;
use Modules\PortalAdministration\Database\Seeders\Portal\LampiranSeeder;
use Modules\PortalAdministration\Database\Seeders\Portal\LaporanTeknikalSeeder;
use Modules\PortalAdministration\Database\Seeders\Portal\LatarBelakangSeeder;
use Modules\PortalAdministration\Database\Seeders\Portal\ObjektifOrganisasiSeeder;
use Modules\PortalAdministration\Database\Seeders\Portal\PengenalanDiriSeeder;
use Modules\PortalAdministration\Database\Seeders\Portal\PenghargaanSeeder;
use Modules\PortalAdministration\Database\Seeders\Portal\CmsSettingSeeder;
use Modules\PortalAdministration\Database\Seeders\Portal\RingkasanAktivitiSeeder;
use Modules\PortalAdministration\Database\Seeders\Portal\RumusanSeeder;
use Modules\PortalAdministration\Database\Seeders\Portal\VisiMisiSeeder;

class PortalSettingSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            HeaderFooterSeeder::class,
            CmsSettingSeeder::class,
            HomeSeeder::class,
            PengenalanDiriSeeder::class,
            LatarBelakangSeeder::class,
            ObjektifOrganisasiSeeder::class,
            VisiMisiSeeder::class,
            CartaOrganisasiSeeder::class,
            FungsiBahagianSeeder::class,
            HalatujuOrganisasiSeeder::class,
            PenghargaanSeeder::class,
            RingkasanAktivitiSeeder::class,
            LaporanTeknikalSeeder::class,
            RumusanSeeder::class,
            LampiranSeeder::class,
        ]);
    }
}
