<?php

declare(strict_types=1);

return [
    /*
    |--------------------------------------------------------------------------
    | Guest shell (layout log masuk / daftar)
    |--------------------------------------------------------------------------
    */
    'guest' => [
        'theme_aria_label' => 'Theme',
    ],

    /*
    |--------------------------------------------------------------------------
    | Tab utama
    |--------------------------------------------------------------------------
    */
    'tabs' => [
        'login'    => 'Login',
        'register' => 'Register',
    ],

    /*
    |--------------------------------------------------------------------------
    | Skrin log masuk
    |--------------------------------------------------------------------------
    */
    'login' => [
        'heading'     => 'Login',
        'description' => 'Sign in with your email and password.',
        'submit'      => 'Log in',
    ],

    /*
    |--------------------------------------------------------------------------
    | Skrin daftar
    |--------------------------------------------------------------------------
    */
    'register' => [
        'heading'              => 'Register',
        'description'          => 'Create your account. An administrator must approve it before you can sign in.',
        'submit'               => 'Register',
        'pending_approval'     => 'Thanks for registering. Your account is pending approval—you can sign in once an administrator approves it.',
        'pending_badge'        => 'Pending approval',
        'rejected_badge'       => 'Rejected',
        'registration_column'  => 'Registration',
        'approve'              => 'Approve account',
        'confirm_approve'      => 'Approve this account and assign the requested role?',
        'reject'               => 'Reject account',
        'confirm_reject'       => 'Reject this registration? (The user will not be able to sign in.)',
    ],

    /*
    |--------------------------------------------------------------------------
    | Label / placeholder medan (kongsi antara skrin)
    |--------------------------------------------------------------------------
    */
    'field' => [
        'email'             => 'Email',
        'password'          => 'Password',
        'name'              => 'Name',
        'confirm_password'  => 'Confirm Password',
        'requested_role'    => 'Requested role',
        'select_role'       => 'Select a role…',
    ],

    'remember_me' => 'Remember me',

    /*
    |--------------------------------------------------------------------------
    | Lupa kata laluan
    |--------------------------------------------------------------------------
    */
    'forgot' => [
        'link_text'   => 'Forgot your password?',
        'heading'     => 'Forgot your password?',
        'description' => 'Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.',
        'submit'      => 'Email Password Reset Link',
        'back'        => 'Back to login',
    ],

    /*
    |--------------------------------------------------------------------------
    | Tetap semula kata laluan
    |--------------------------------------------------------------------------
    */
    'reset' => [
        'heading'     => 'Reset Password',
        'description' => 'Choose a new password for your account.',
        'submit'      => 'Reset Password',
    ],

    /*
    |--------------------------------------------------------------------------
    | Sahkan kata laluan (kawasan selamat)
    |--------------------------------------------------------------------------
    */
    'password_gate' => [
        'heading'     => 'Confirm password',
        'description' => 'This is a secure area of the application. Please confirm your password before continuing.',
        'submit'      => 'Confirm',
    ],

    /*
    |--------------------------------------------------------------------------
    | Sahkan e-mel
    |--------------------------------------------------------------------------
    */
    'verify_email' => [
        'heading'        => 'Verify Email Address',
        'intro'          => 'Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.',
        'link_sent'      => 'A new verification link has been sent to the email address you provided during registration.',
        'resend_button'  => 'Resend Verification Email',
        'log_out'        => 'Log Out',
    ],
];
