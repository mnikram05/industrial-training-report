<?php

declare(strict_types=1);

return [
    'model'        => 'Daerah',
    'plural'       => 'Daerah',
    'new'          => 'Daerah Baharu',
    'index'        => 'Butiran Daerah',
    'list'         => 'Senarai Daerah',
    'edit'         => 'Edit Daerah',
    'delete'       => 'Padam Daerah',
    'create'       => 'Cipta Daerah',
    'subtitle'     => 'Urus rujukan daerah.',
    'filter'       => 'Tapis daerah...',
    'sort_options' => [
        'first' => '1 - Pertama',
        'after' => ':position - Selepas :name',
    ],
    'placeholders' => [
        'state' => 'Pilih negeri',
    ],
    'fields' => [
        'ddsa_code'   => 'Kod DDSA',
        'name'        => 'Nama',
        'fullname'    => 'Nama Penuh',
        'state'       => 'Negeri',
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
