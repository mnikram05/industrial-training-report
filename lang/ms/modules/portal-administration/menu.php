<?php

declare(strict_types=1);

return [
    'model'        => 'Menu',
    'plural'       => 'Menu',
    'new'          => 'Menu Baharu',
    'index'        => 'Butiran Menu',
    'list'         => 'Senarai Menu',
    'edit'         => 'Edit Menu',
    'delete'       => 'Padam Menu',
    'create'       => 'Cipta Menu',
    'subtitle'     => 'Urus menu portal.',
    'filter'       => 'Tapis menu...',
    'sort_options' => [
        'first' => '1 - Pertama',
        'after' => ':position - Selepas :name',
    ],
    'placeholders' => [
        'parent'    => 'Pilih induk',
        'type'      => 'Pilih jenis menu',
        'icon_none' => '— Tiada Ikon —',
    ],
    'fields' => [
        'title_en'    => 'Tajuk (EN)',
        'title_ms'    => 'Tajuk (MS)',
        'parent'      => 'Induk',
        'url'         => 'URL',
        'slug'        => 'Slug',
        'icon'        => 'Ikon',
        'type'        => 'Jenis',
        'sort'        => 'Susunan',
        'status'      => 'Status',
        'created'     => 'Dicipta',
        'created_at'  => 'Tarikh Cipta',
        'created_by'  => 'Dicipta Oleh',
        'updated'     => 'Dikemaskini',
        'updated_at'  => 'Tarikh Dikemaskini',
        'updated_by'  => 'Dikemaskini Oleh',
        'deleted_at'  => 'Tarikh Dipadam',
        'deleted_by'  => 'Dipadam Oleh',
        'sort_action' => 'Kemaskini Susunan',
    ],
];
