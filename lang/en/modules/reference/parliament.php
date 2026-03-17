<?php

declare(strict_types=1);

return [
    'model'        => 'Parliament',
    'plural'       => 'Parliaments',
    'new'          => 'New Parliament',
    'index'        => 'Parliament Detail',
    'list'         => 'List of Parliaments',
    'edit'         => 'Edit Parliament',
    'delete'       => 'Delete of Parliament',
    'create'       => 'Create Parliament',
    'subtitle'     => 'Manage reference parliaments.',
    'filter'       => 'Filter parliaments...',
    'sort_options' => [
        'first' => '1st - First',
        'after' => ':position - After :name',
    ],
    'placeholders' => [
        'state' => 'Select a state',
    ],
    'fields' => [
        'ddsa_code'   => 'DDSA Code',
        'new_code'    => 'New Code',
        'name'        => 'Name',
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
