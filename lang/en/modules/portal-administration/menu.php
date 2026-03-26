<?php

declare(strict_types=1);

return [
    'model'        => 'Menu',
    'plural'       => 'Menus',
    'new'          => 'New Menu',
    'index'        => 'Menu Detail',
    'list'         => 'List of Menus',
    'edit'         => 'Edit Menu',
    'delete'       => 'Delete of Menu',
    'create'       => 'Create Menu',
    'subtitle'     => 'Manage portal menus.',
    'filter'       => 'Filter menus...',
    'sort_options' => [
        'first' => '1st - First',
        'after' => ':position - After :name',
    ],
    'placeholders' => [
        'parent'    => 'Select a parent',
        'type'      => 'Select a menu type',
        'icon_none' => '— No Icon —',
    ],
    'fields' => [
        'title_en'    => 'Title (EN)',
        'title_my'    => 'Title (MY)',
        'parent'      => 'Parent',
        'url'         => 'URL',
        'slug'        => 'Slug',
        'icon'        => 'Icon',
        'type'        => 'Type',
        'sort'        => 'Sort',
        'status'      => 'Status',
        'created'     => 'Created',
        'created_at'  => 'Created At',
        'created_by'  => 'Created By',
        'updated'     => 'Updated',
        'updated_at'  => 'Updated At',
        'updated_by'  => 'Updated By',
        'deleted_at'  => 'Deleted At',
        'deleted_by'  => 'Deleted By',
        'sort_action' => 'Update Sort',
    ],
];
