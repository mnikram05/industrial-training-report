<?php

declare(strict_types=1);

use App\Modules\User\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('guests are redirected from the dashboard', function (): void {
    $this->get(route('dashboard'))->assertRedirect();
});

test('authenticated users can view the dashboard with quick links and checklist', function (): void {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('dashboard'))
        ->assertOk()
        ->assertSee(__('dashboard.shortcuts_heading'), false)
        ->assertSee(__('dashboard.checklist_heading'), false);
});

test('authenticated app layout includes idle auto logout meta aligned with session lifetime', function (): void {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('dashboard'))
        ->assertOk()
        ->assertSee('name="idle-auto-logout-minutes"', false)
        ->assertSee('content="'.config('session.lifetime').'"', false);
});
