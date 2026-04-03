<?php

declare(strict_types=1);

return [
    /*
    |--------------------------------------------------------------------------
    | Guest shell (layout log masuk / daftar)
    |--------------------------------------------------------------------------
    */
    'guest' => [
        'theme_aria_label' => 'Tema',
    ],

    /*
    |--------------------------------------------------------------------------
    | Tab utama
    |--------------------------------------------------------------------------
    */
    'tabs' => [
        'login'    => 'Log masuk',
        'register' => 'Daftar',
    ],

    /*
    |--------------------------------------------------------------------------
    | Skrin log masuk
    |--------------------------------------------------------------------------
    */
    'login' => [
        'heading'     => 'Log masuk',
        'description' => 'Log masuk dengan e-mel dan kata laluan anda.',
        'submit'      => 'Log masuk',
    ],

    /*
    |--------------------------------------------------------------------------
    | Skrin daftar
    |--------------------------------------------------------------------------
    */
    'register' => [
        'heading'     => 'Daftar',
        'description' => 'Cipta akaun anda dengan nama dan kata laluan.',
        'submit'      => 'Daftar',
    ],

    /*
    |--------------------------------------------------------------------------
    | Label / placeholder medan (kongsi antara skrin)
    |--------------------------------------------------------------------------
    */
    'field' => [
        'email'             => 'E-mel',
        'password'          => 'Kata laluan',
        'name'              => 'Nama',
        'confirm_password'  => 'Sahkan kata laluan',
    ],

    'remember_me' => 'Ingat saya',

    /*
    |--------------------------------------------------------------------------
    | Lupa kata laluan
    |--------------------------------------------------------------------------
    */
    'forgot' => [
        'link_text'   => 'Lupa kata laluan anda?',
        'heading'     => 'Lupa kata laluan?',
        'description' => 'Lupa kata laluan anda? Tiada masalah. Beritahu kami alamat e-mel anda dan kami akan menghantar pautan tetapan semula kata laluan untuk anda memilih yang baharu.',
        'submit'      => 'Hantar pautan tetapan semula melalui e-mel',
        'back'        => 'Kembali ke log masuk',
    ],

    /*
    |--------------------------------------------------------------------------
    | Tetap semula kata laluan
    |--------------------------------------------------------------------------
    */
    'reset' => [
        'heading'     => 'Tetap semula kata laluan',
        'description' => 'Pilih kata laluan baharu untuk akaun anda.',
        'submit'      => 'Tetap semula kata laluan',
    ],

    /*
    |--------------------------------------------------------------------------
    | Sahkan kata laluan (kawasan selamat)
    |--------------------------------------------------------------------------
    */
    'password_gate' => [
        'heading'     => 'Sahkan kata laluan',
        'description' => 'Ini ialah kawasan selamat aplikasi. Sila sahkan kata laluan anda sebelum meneruskan.',
        'submit'      => 'Sahkan',
    ],

    /*
    |--------------------------------------------------------------------------
    | Sahkan e-mel
    |--------------------------------------------------------------------------
    */
    'verify_email' => [
        'heading'       => 'Mengesahkan alamat e-mel',
        'intro'         => 'Terima kasih kerana mendaftar! Sebelum bermula, bolehkah anda sahkan alamat e-mel dengan menekan pautan yang baru kami e-melkan kepada anda? Jika anda tidak menerima e-mel tersebut, kami dengan senang hati akan menghantar yang baharu.',
        'link_sent'     => 'Pautan pengesahan baharu telah dihantar ke alamat e-mel yang anda berikan semasa pendaftaran.',
        'resend_button' => 'Hantar semula e-mel pengesahan',
        'log_out'       => 'Log keluar',
    ],
];
