<?php

declare(strict_types=1);

namespace Modules\PortalAdministration\Support;

/**
 * Stable paths under storage/app/public for portal images (hosting-friendly).
 * Copy or symlink legacy uploads into media/portal/ using these filenames.
 *
 * Semua gambar portal penting didaftarkan di sini. Untuk seed Media + halaman portal,
 * guna constant ini atau portalMediaCatalog() — jangan hanya salin string path di tempat lain.
 */
final class PortalPublicMediaPaths
{
    public const PREFIX = 'media/portal';

    /** Logo header/footer portal */
    public const LOGO_SITE = 'media/portal/logo-site.png';

    /** Foto profil pelajar (home, pengenalan diri) */
    public const PROFILE_PELAJAR = 'media/portal/profile-pelajar.jpg';

    /** Logo syarikat latihan (home, latar belakang) */
    public const LOGO_OPENSOFT = 'media/portal/logo-opensoft.jpg';

    /** Rajah carta organisasi */
    public const CARTA_ORGANISASI = 'media/portal/carta-organisasi.jpg';

    /** Imej lokasi pejabat */
    public const LOKASI_OPENSOFT = 'media/portal/lokasi-opensoft.png';

    /** Aktiviti / perniagaan teras */
    public const PERNIAGAAN_TERAS = 'media/portal/perniagaan-teras.png';

    /** Laporan teknikal — langkah migration */
    public const TEKNIKAL_MIGRATION = 'media/portal/teknikal-migration.png';

    /** Laporan teknikal — seeder */
    public const TEKNIKAL_SEEDER = 'media/portal/teknikal-seeder.png';

    /** Laporan teknikal — model */
    public const TEKNIKAL_MODEL = 'media/portal/teknikal-model.png';

    /** Laporan teknikal — controller */
    public const TEKNIKAL_CONTROLLER = 'media/portal/teknikal-controller.png';

    /** Laporan teknikal — route */
    public const TEKNIKAL_ROUTE = 'media/portal/teknikal-route.png';

    /** Laporan teknikal — hasil akhir */
    public const TEKNIKAL_HASIL = 'media/portal/teknikal-hasil.png';

    /** Lampiran — mesyuarat Swcorp */
    public const LAMPIRAN_MESYUARAT_SWCORP = 'media/portal/lampiran-mesyuarat-swcorp.jpg';

    /** Lampiran — ruang kerja / persekitaran latihan (Gambar II) */
    public const LAMPIRAN_II_RUANG_KERJA = 'media/portal/lampiran-ii-ruang-kerja.jpg';

    /**
     * Rekod untuk MediaSeeder — satu senarai, senang tambah gambar baharu di sini sahaja.
     *
     * @return list<array{
     *     name: string,
     *     file_name: string,
     *     mime_type: string,
     *     path: string,
     *     disk: string,
     *     size: int,
     *     collection: string
     * }>
     */
    public static function portalMediaCatalog(): array
    {
        return [
            [
                'name'       => 'logo',
                'file_name'  => 'logo-site.png',
                'mime_type'  => 'image/png',
                'path'       => self::LOGO_SITE,
                'disk'       => 'public',
                'size'       => 38976,
                'collection' => 'Logo',
            ],
            [
                'name'       => 'profile',
                'file_name'  => 'profile-pelajar.jpg',
                'mime_type'  => 'image/jpeg',
                'path'       => self::PROFILE_PELAJAR,
                'disk'       => 'public',
                'size'       => 91725,
                'collection' => 'Gambar Ikram',
            ],
            [
                'name'       => 'opensoft_logo',
                'file_name'  => 'logo-opensoft.jpg',
                'mime_type'  => 'image/jpeg',
                'path'       => self::LOGO_OPENSOFT,
                'disk'       => 'public',
                'size'       => 6728,
                'collection' => 'OST',
            ],
            [
                'name'       => 'carta-organisasi-opensoft',
                'file_name'  => 'carta-organisasi.jpg',
                'mime_type'  => 'image/jpeg',
                'path'       => self::CARTA_ORGANISASI,
                'disk'       => 'public',
                'size'       => 8590313,
                'collection' => 'carta-organisasi',
            ],
            [
                'name'       => 'opensoft_location',
                'file_name'  => 'lokasi-opensoft.png',
                'mime_type'  => 'image/png',
                'path'       => self::LOKASI_OPENSOFT,
                'disk'       => 'public',
                'size'       => 146836,
                'collection' => '',
            ],
            [
                'name'       => 'core_business',
                'file_name'  => 'perniagaan-teras.png',
                'mime_type'  => 'image/png',
                'path'       => self::PERNIAGAAN_TERAS,
                'disk'       => 'public',
                'size'       => 61765,
                'collection' => 'core-business',
            ],
            [
                'name'       => 'Screenshot 2026-03-26 100439',
                'file_name'  => 'teknikal-model.png',
                'mime_type'  => 'image/png',
                'path'       => self::TEKNIKAL_MODEL,
                'disk'       => 'public',
                'size'       => 162803,
                'collection' => 'model',
            ],
            [
                'name'       => 'Screenshot 2026-03-26 100536',
                'file_name'  => 'teknikal-migration.png',
                'mime_type'  => 'image/png',
                'path'       => self::TEKNIKAL_MIGRATION,
                'disk'       => 'public',
                'size'       => 237614,
                'collection' => 'migration',
            ],
            [
                'name'       => 'Screenshot 2026-03-26 100613',
                'file_name'  => 'teknikal-seeder.png',
                'mime_type'  => 'image/png',
                'path'       => self::TEKNIKAL_SEEDER,
                'disk'       => 'public',
                'size'       => 185222,
                'collection' => 'seeder',
            ],
            [
                'name'       => 'Screenshot 2026-03-26 100721',
                'file_name'  => 'teknikal-controller.png',
                'mime_type'  => 'image/png',
                'path'       => self::TEKNIKAL_CONTROLLER,
                'disk'       => 'public',
                'size'       => 208459,
                'collection' => 'controller',
            ],
            [
                'name'       => 'Screenshot 2026-03-26 100810',
                'file_name'  => 'teknikal-route.png',
                'mime_type'  => 'image/png',
                'path'       => self::TEKNIKAL_ROUTE,
                'disk'       => 'public',
                'size'       => 203937,
                'collection' => 'route',
            ],
            [
                'name'       => 'laporan-teknikal-hasil',
                'file_name'  => 'teknikal-hasil.png',
                'mime_type'  => 'image/png',
                'path'       => self::TEKNIKAL_HASIL,
                'disk'       => 'public',
                'size'       => 405265,
                'collection' => 'hasil',
            ],
            [
                'name'       => 'mesyuarat-swcorp-pembangun',
                'file_name'  => 'lampiran-mesyuarat-swcorp.jpg',
                'mime_type'  => 'image/jpeg',
                'path'       => self::LAMPIRAN_MESYUARAT_SWCORP,
                'disk'       => 'public',
                'size'       => 0,
                'collection' => 'lampiran',
            ],
            [
                'name'       => 'lampiran-ii-ruang-kerja',
                'file_name'  => 'lampiran-ii-ruang-kerja.jpg',
                'mime_type'  => 'image/jpeg',
                'path'       => self::LAMPIRAN_II_RUANG_KERJA,
                'disk'       => 'public',
                'size'       => 0,
                'collection' => 'lampiran',
            ],
        ];
    }

    /**
     * Map old hashed paths (pre–media/portal) → new semantic paths for one-off file migration.
     *
     * @return array<string, string>
     */
    public static function legacyPathMap(): array
    {
        return [
            'media/2026/03/9QYSvTREqIhtB0vOS2sM48Xo0QiV7vx3zrt7mvgh.png' => self::LOGO_SITE,
            'media/2026/03/Hr2cdTUy89BSx10ARvj91jcFPKBtkgDtY8nybFFe.jpg' => self::PROFILE_PELAJAR,
            'media/2026/03/QUMc6Oxeksi48tguONAl2giNSYvhM5YGgo8yLOlU.jpg' => self::LOGO_OPENSOFT,
            'media/2026/03/jcFSrBNohgu3gNF4TgjVdtDXhFxktWTf6Z9SXw73.jpg' => self::CARTA_ORGANISASI,
            'media/2026/03/uYiapMLscFgsa0nBpg6R9u8tqxx7RFqSfPbp3B68.png' => self::LOKASI_OPENSOFT,
            'media/2026/03/UPloP9UcRm0jMNp5JyVOmR8blR1gVZ45Nk2BFgoW.png' => self::PERNIAGAAN_TERAS,
            'media/2026/03/dfUHXD0uvyad7BH8qXJRKSWI1R5niHnX3iaK6lWk.png' => self::TEKNIKAL_MODEL,
            'media/2026/03/7MYSJ98wgROtSOGqmqV3grn3KCbNhJCPjH6qXg8T.png' => self::TEKNIKAL_MIGRATION,
            'media/2026/03/yO2EBXkWy5Nnf1bjWpwdE6R1GYKj85fYVRfxYtTD.png' => self::TEKNIKAL_SEEDER,
            'media/2026/03/3xXVI5MHSDbj7dn6PQWvtE5sP3qxZUi2IvwQnTCW.png' => self::TEKNIKAL_CONTROLLER,
            'media/2026/03/QPvzPgHpHDfv1YkyKkFaAWfS8T1ojy7hxOPLKtgh.png' => self::TEKNIKAL_ROUTE,
            'media/2026/04/pC3qbUFfLeyp6x75Pp1PozfFwsxroKydg4MnIN89.png' => self::TEKNIKAL_HASIL,
            'media/2026/04/mesyuarat-swcorp-pembangun.jpg'               => self::LAMPIRAN_MESYUARAT_SWCORP,
        ];
    }
}
