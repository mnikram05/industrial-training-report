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

test('users without media permission cannot access media index or datatable json', function (): void {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('media.index'))
        ->assertForbidden();

    $this->actingAs($user)
        ->get(route('media.data'))
        ->assertForbidden();
});

test('admin can access media index and data', function (): void {
    $user = User::factory()->create();
    $user->assignRole(RoleNameConstants::ADMIN);

    $this->actingAs($user)
        ->get(route('media.index'))
        ->assertOk();

    $this->actingAs($user)
        ->get(route('media.data'))
        ->assertOk();
});

test('editor can view media but viewer cannot', function (): void {
    $editor = User::factory()->create();
    $editor->assignRole(RoleNameConstants::EDITOR);

    $this->actingAs($editor)
        ->get(route('media.index'))
        ->assertOk();

    $viewer = User::factory()->create();
    $viewer->assignRole(RoleNameConstants::VIEWER);

    $this->actingAs($viewer)
        ->get(route('media.index'))
        ->assertForbidden();
});
