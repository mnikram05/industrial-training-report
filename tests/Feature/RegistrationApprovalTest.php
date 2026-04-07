<?php

declare(strict_types=1);

use App\Modules\Role\Constants\RoleNameConstants;
use App\Modules\User\Models\User;
use Database\Seeders\RoleAndPermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses( RefreshDatabase::class );

beforeEach( function (): void {
    $this->seed( RoleAndPermissionSeeder::class );
} );

test( 'registration creates a pending user with requested role and does not log them in', function (): void {
    $response = $this->post( route( 'register' ), [
        'name'                  => 'New User',
        'email'                 => 'new@example.com',
        'password'              => 'password',
        'password_confirmation' => 'password',
        'requested_role'        => RoleNameConstants::EDITOR,
        '_auth_tab'             => 'register',
    ] );

    $response->assertRedirect( route( 'login' ) );
    $response->assertSessionHas( 'status' );

    $user = User::query()->where( 'email', 'new@example.com' )->first();

    expect( $user )->not->toBeNull()
        ->and( $user->approved_at )->toBeNull()
        ->and( $user->requested_role )->toBe( RoleNameConstants::EDITOR )
        ->and( $user->roles )->toHaveCount( 0 );

    $this->assertGuest();
} );

test( 'pending user cannot log in', function (): void {
    $user = User::factory()->pendingRegistration()->create();
    $user->storePassword( 'password' );

    $this->post( route( 'login' ), [
        'email'    => $user->email,
        'password' => 'password',
    ] )->assertSessionHasErrors( 'email' );

    $this->assertGuest();
} );

test( 'rejected user cannot log in', function (): void {
    $user = User::factory()->pendingRegistration()->create( [
        'rejected_at' => now(),
    ] );
    $user->storePassword( 'password' );

    $this->post( route( 'login' ), [
        'email'    => $user->email,
        'password' => 'password',
    ] )->assertSessionHasErrors( 'email' );

    $this->assertGuest();
} );

test( 'admin can approve a pending user who may then log in', function (): void {
    $admin = User::factory()->create();
    $admin->assignRole( RoleNameConstants::ADMIN );

    $pending = User::factory()->pendingRegistration()->create();
    $pending->storePassword( 'password' );

    $this->actingAs( $admin )
        ->patch( route( 'users.approve', $pending ) )
        ->assertRedirect( route( 'users.index' ) );

    $pending->refresh();

    expect( $pending->approved_at )->not->toBeNull()
        ->and( $pending->hasRole( RoleNameConstants::EDITOR ) )->toBeTrue();

    $this->post( route( 'logout' ) );

    $this->post( route( 'login' ), [
        'email'    => $pending->email,
        'password' => 'password',
    ] )->assertRedirect( route( 'dashboard', absolute: false ) );
} );
