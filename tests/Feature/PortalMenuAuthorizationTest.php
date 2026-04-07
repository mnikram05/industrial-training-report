<?php

declare(strict_types=1);

use App\Modules\Role\Constants\RoleNameConstants;
use App\Modules\User\Models\User;
use Database\Seeders\RoleAndPermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function (): void {
    $this->seed(RoleAndPermissionSeeder::class);
});

test('users without menus permission cannot list menus or load the datatable json', function (): void {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('portal-administration.menus.index'))
        ->assertForbidden();

    $this->actingAs($user)
        ->get(route('portal-administration.menus.data'))
        ->assertForbidden();
});

test('admin can view menus index and menus data endpoint', function (): void {
    $user = User::factory()->create();
    $user->assignRole(RoleNameConstants::ADMIN);

    $this->actingAs($user)
        ->get(route('portal-administration.menus.index'))
        ->assertOk();

    $this->actingAs($user)
        ->get(route('portal-administration.menus.data'))
        ->assertOk();
});

test('editor can view menus index and data but viewer cannot', function (): void {
    $editor = User::factory()->create();
    $editor->assignRole(RoleNameConstants::EDITOR);

    $this->actingAs($editor)
        ->get(route('portal-administration.menus.index'))
        ->assertOk();

    $this->actingAs($editor)
        ->get(route('portal-administration.menus.data'))
        ->assertOk();

    $viewer = User::factory()->create();
    $viewer->assignRole(RoleNameConstants::VIEWER);

    $this->actingAs($viewer)
        ->get(route('portal-administration.menus.index'))
        ->assertForbidden();
});
