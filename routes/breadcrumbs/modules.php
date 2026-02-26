<?php

declare(strict_types=1);

$files = glob( __DIR__ . '/modules/*.php' );

if ( is_array( $files ) ) {
    sort( $files );

    foreach ( $files as $file ) {
        require $file;
    }
}
