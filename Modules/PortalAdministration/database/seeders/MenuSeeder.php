<?php

declare(strict_types=1);

namespace Modules\PortalAdministration\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Reference\Models\DataReference;
use Modules\PortalAdministration\Models\Menu;
use Modules\PortalAdministration\Models\PortalSetting;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        $menuTypeParent = DataReference::query()
            ->where( 'label_my', 'Jenis Menu' )
            ->whereNull( 'parent_id' )
            ->first();

        $typeAtas     = DataReference::query()->where( 'label_my', 'Atas' )->where( 'parent_id', $menuTypeParent->id )->first();
        $typeBawah    = DataReference::query()->where( 'label_my', 'Bawah' )->where( 'parent_id', $menuTypeParent->id )->first();
        $typeLain     = DataReference::query()->where( 'label_my', 'Lain-lain' )->where( 'parent_id', $menuTypeParent->id )->first();
        $typeNavCepat = DataReference::query()->where( 'label_my', 'Navigasi Cepat' )->where( 'parent_id', $menuTypeParent->id )->first();

        // Parent menus
        $atas = Menu::query()->updateOrCreate(
            ['title_my' => 'Atas', 'parent_id' => null],
            ['title_en' => 'Top', 'type_id' => $typeAtas->id, 'status_id' => 1, 'icon' => '1', 'sort' => 1],
        );

        $bawah = Menu::query()->updateOrCreate(
            ['title_my' => 'Bawah', 'parent_id' => null],
            ['title_en' => 'Down', 'type_id' => $typeBawah->id, 'status_id' => 1, 'icon' => '1', 'sort' => 2],
        );

        Menu::query()->updateOrCreate(
            ['title_my' => 'Lain-lain', 'parent_id' => null],
            ['title_en' => 'Others', 'type_id' => $typeLain->id, 'status_id' => 1, 'icon' => '1', 'sort' => 3],
        );

        $navCepat = Menu::query()->updateOrCreate(
            ['title_my' => 'Navigasi Cepat', 'parent_id' => null],
            ['title_en' => 'Quick Navigation', 'type_id' => $typeNavCepat->id, 'status_id' => 1, 'icon' => '1', 'sort' => 4],
        );

        // SVG icons (Heroicons outline)
        $iconHome     = '<svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/></svg>';
        $iconUser     = '<svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/></svg>';
        $iconIdCard   = '<svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Zm6-10.125a1.875 1.875 0 1 1-3.75 0 1.875 1.875 0 0 1 3.75 0Zm1.294 6.336a6.721 6.721 0 0 1-3.17.789 6.721 6.721 0 0 1-3.168-.789 3.376 3.376 0 0 1 6.338 0Z"/></svg>';
        $iconCalendar = '<svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5"/></svg>';
        $iconDoc      = '<svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"/></svg>';

        // Children of Atas (Top Menu)
        Menu::query()->updateOrCreate(
            ['title_my' => 'HOME', 'parent_id' => $atas->id],
            ['title_en' => 'HOME', 'status_id' => 1, 'icon' => $iconHome, 'sort' => 1, 'url' => '/portal', 'slug' => 'Home'],
        );

        $pengenalan = Menu::query()->updateOrCreate(
            ['title_my' => 'PENGENALAN', 'parent_id' => $atas->id],
            ['title_en' => 'INTRODUCTION', 'status_id' => 1, 'icon' => $iconUser, 'sort' => 2],
        );

        $iconHeart = '<svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z"/></svg>';

        Menu::query()->updateOrCreate(
            ['title_my' => 'PENGHARGAAN', 'parent_id' => $atas->id],
            ['title_en' => 'ACKNOWLEDGEMENT', 'status_id' => 1, 'icon' => $iconHeart, 'sort' => 3, 'url' => '/portal/penghargaan', 'slug' => 'penghargaan'],
        );

        Menu::query()->updateOrCreate(
            ['title_my' => 'RINGKASAN AKTIVITI', 'parent_id' => $atas->id],
            ['title_en' => 'ACTIVITY SUMMARY', 'status_id' => 1, 'icon' => $iconCalendar, 'sort' => 4, 'url' => '/portal/ringkasan-aktiviti', 'slug' => 'ringkasan-aktiviti'],
        );

        Menu::query()->updateOrCreate(
            ['title_my' => 'LAPORAN TEKNIKAL', 'parent_id' => $atas->id],
            ['title_en' => 'TECHNICAL REPORT', 'status_id' => 1, 'icon' => $iconDoc, 'sort' => 5, 'url' => '/portal/laporan-teknikal', 'slug' => 'laporan-teknikal'],
        );

        $iconPencil = '<svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10"/></svg>';

        Menu::query()->updateOrCreate(
            ['title_my' => 'RUMUSAN', 'parent_id' => $atas->id],
            ['title_en' => 'CONCLUSION', 'status_id' => 1, 'icon' => $iconPencil, 'sort' => 6, 'url' => '/portal/rumusan', 'slug' => 'rumusan'],
        );

        $iconPaperClip = '<svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m18.375 12.739-7.693 7.693a4.5 4.5 0 0 1-6.364-6.364l10.94-10.94A3 3 0 1 1 19.5 7.372L8.552 18.32m.009-.01-.01.01m5.699-9.941-7.81 7.81a1.503 1.503 0 0 0 2.124 2.124l7.81-7.81"/></svg>';

        Menu::query()->updateOrCreate(
            ['title_my' => 'LAMPIRAN', 'parent_id' => $atas->id],
            ['title_en' => 'APPENDICES', 'status_id' => 1, 'icon' => $iconPaperClip, 'sort' => 7, 'url' => '/portal/lampiran', 'slug' => 'lampiran'],
        );

        Menu::query()->updateOrCreate(
            ['title_my' => 'PENGENALAN DIRI', 'parent_id' => $pengenalan->id],
            ['title_en' => 'SELF INTRODUCTION', 'status_id' => 1, 'icon' => $iconIdCard, 'sort' => 1, 'url' => '/portal/pengenalan-diri', 'slug' => 'pengenalan-diri'],
        );

        $iconBuilding = '<svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21"/></svg>';

        Menu::query()->updateOrCreate(
            ['title_my' => 'LATAR BELAKANG ORGANISASI', 'parent_id' => $pengenalan->id],
            ['title_en' => 'ORGANISATION BACKGROUND', 'status_id' => 1, 'icon' => $iconBuilding, 'sort' => 2, 'url' => '/portal/latar-belakang', 'slug' => 'latar-belakang'],
        );

        $iconTarget = '<svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>';

        Menu::query()->updateOrCreate(
            ['title_my' => 'OBJEKTIF ORGANISASI', 'parent_id' => $pengenalan->id],
            ['title_en' => 'ORGANISATION OBJECTIVES', 'status_id' => 1, 'icon' => $iconTarget, 'sort' => 3, 'url' => '/portal/objektif-organisasi', 'slug' => 'objektif-organisasi'],
        );

        $iconEye = '<svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/></svg>';

        Menu::query()->updateOrCreate(
            ['title_my' => 'VISI & MISI', 'parent_id' => $pengenalan->id],
            ['title_en' => 'VISION & MISSION', 'status_id' => 1, 'icon' => $iconEye, 'sort' => 4, 'url' => '/portal/visi-misi', 'slug' => 'visi-misi'],
        );

        $iconChart = '<svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z"/></svg>';

        Menu::query()->updateOrCreate(
            ['title_my' => 'CARTA ORGANISASI', 'parent_id' => $pengenalan->id],
            ['title_en' => 'ORGANIZATION CHART', 'status_id' => 1, 'icon' => $iconChart, 'sort' => 5, 'url' => '/portal/carta-organisasi', 'slug' => 'carta-organisasi'],
        );

        $iconCog = '<svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.241-.438.613-.431.992a7.723 7.723 0 0 1 0 .255c-.007.378.138.75.43.991l1.004.827c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.47 6.47 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.431l1.004-.827c.292-.24.437-.613.43-.991a6.932 6.932 0 0 1 0-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.28Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/></svg>';

        Menu::query()->updateOrCreate(
            ['title_my' => 'FUNGSI BAHAGIAN', 'parent_id' => $pengenalan->id],
            ['title_en' => 'DEPARTMENT FUNCTIONS', 'status_id' => 1, 'icon' => $iconCog, 'sort' => 6, 'url' => '/portal/fungsi-bahagian', 'slug' => 'fungsi-bahagian'],
        );

        $iconCompass = '<svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 0 0 8.716-6.747M12 21a9.004 9.004 0 0 1-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 0 1 7.843 4.582M12 3a8.997 8.997 0 0 0-7.843 4.582m15.686 0A11.953 11.953 0 0 1 12 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0 1 21 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0 1 12 16.5a17.92 17.92 0 0 1-8.716-2.247m0 0A8.966 8.966 0 0 1 3 12c0-1.264.26-2.467.732-3.558"/></svg>';

        Menu::query()->updateOrCreate(
            ['title_my' => 'HALATUJU ORGANISASI', 'parent_id' => $pengenalan->id],
            ['title_en' => 'ORGANISATION DIRECTION', 'status_id' => 1, 'icon' => $iconCompass, 'sort' => 7, 'url' => '/portal/halatuju-organisasi', 'slug' => 'halatuju-organisasi'],
        );

        // Children of Bawah (Footer Menu)
        Menu::query()->updateOrCreate(
            ['title_my' => 'Laman Utama', 'parent_id' => $bawah->id],
            ['title_en' => 'Home', 'status_id' => 1, 'icon' => $iconHome, 'sort' => 1, 'url' => '/portal', 'slug' => 'home'],
        );

        Menu::query()->updateOrCreate(
            ['title_my' => 'Pengenalan Diri', 'parent_id' => $bawah->id],
            ['title_en' => 'Self Introduction', 'status_id' => 1, 'icon' => $iconIdCard, 'sort' => 2, 'url' => '/portal/pengenalan-diri', 'slug' => 'pengenalan-diri'],
        );

        Menu::query()->updateOrCreate(
            ['title_my' => 'Ringkasan Aktiviti', 'parent_id' => $bawah->id],
            ['title_en' => 'Activity Summary', 'status_id' => 1, 'icon' => $iconCalendar, 'sort' => 3, 'url' => '/portal/ringkasan-aktiviti', 'slug' => 'ringkasan-aktiviti'],
        );

        Menu::query()->updateOrCreate(
            ['title_my' => 'Laporan Teknikal', 'parent_id' => $bawah->id],
            ['title_en' => 'Technical Report', 'status_id' => 1, 'icon' => $iconDoc, 'sort' => 4, 'url' => '/portal/laporan-teknikal', 'slug' => 'laporan-teknikal'],
        );

        Menu::query()->updateOrCreate(
            ['title_my' => 'Rumusan', 'parent_id' => $bawah->id],
            ['title_en' => 'Conclusion', 'status_id' => 1, 'icon' => $iconPencil, 'sort' => 5, 'url' => '/portal/rumusan', 'slug' => 'rumusan'],
        );

        // Children of Navigasi Cepat
        Menu::query()->updateOrCreate(
            ['title_my' => 'Pengenalan Diri', 'parent_id' => $navCepat->id],
            ['title_en' => 'Self Introduction', 'status_id' => 1, 'icon' => $iconUser, 'sort' => 1, 'url' => '/portal/pengenalan-diri', 'slug' => 'Maklumat pelatih'],
        );

        Menu::query()->updateOrCreate(
            ['title_my' => 'Ringkasan Aktiviti', 'parent_id' => $navCepat->id],
            ['title_en' => 'Activity Summary', 'status_id' => 1, 'icon' => $iconCalendar, 'sort' => 2, 'url' => 'ringkasan-aktiviti', 'slug' => 'Log Mingguan LI'],
        );

        Menu::query()->updateOrCreate(
            ['title_my' => 'Laporan Teknikal', 'parent_id' => $navCepat->id],
            ['title_en' => 'Technical Report', 'status_id' => 1, 'icon' => $iconDoc, 'sort' => 3, 'url' => '/laporan-teknikal', 'slug' => 'Tugasan & projek'],
        );

        // Store menu IDs in header-footer settings
        PortalSetting::setValue( 'menu_atas_id', (string) $atas->id, 'header-footer' );
        PortalSetting::setValue( 'menu_bawah_id', (string) $bawah->id, 'header-footer' );
    }
}
