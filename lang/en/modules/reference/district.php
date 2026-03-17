<?php

declare(strict_types=1);

return [
    'model'        => 'District',
    'plural'       => 'Districts',
    'new'          => 'New District',
    'index'        => 'District Detail',
    'list'         => 'List of Districts',
    'edit'         => 'Edit District',
    'delete'       => 'Delete of District',
    'create'       => 'Create District',
    'subtitle'     => 'Manage reference districts.',
    'filter'       => 'Filter districts...',
    'sort_options' => [
        'first' => '1st - First',
        'after' => ':position - After :name',
    ],
    'placeholders' => [
        'state' => 'Select a state',
    ],
    'fields' => [
        'ddsa_code'   => 'DDSA Code',
        'name'        => 'Name',
        'fullname'    => 'Full Name',
        'state'       => 'State',
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
