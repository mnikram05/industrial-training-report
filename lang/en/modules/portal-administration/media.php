<?php

declare(strict_types=1);

return [
    'model'    => 'Media',
    'plural'   => 'Media',
    'new'      => 'Upload Media',
    'edit'     => 'Edit Media',
    'delete'   => 'Delete Media',
    'subtitle' => 'Manage uploaded files and images.',
    'filter'   => 'Filter media...',
    'fields'   => [
        'preview'     => 'Preview',
        'name'        => 'Name',
        'file_name'   => 'File Name',
        'mime_type'   => 'Type',
        'size'        => 'Size',
        'collection'  => 'Collection',
        'alt'         => 'Alt Text',
        'uploaded_by' => 'Uploaded By',
        'created_at'  => 'Uploaded At',
    ],
    'placeholders' => [
        'collection' => 'e.g. images, documents',
    ],
];
