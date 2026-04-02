<?php

declare(strict_types=1);

use App\Support\PortalTheme;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(Tests\TestCase::class, RefreshDatabase::class);

test('light and dark tailwind tokens look like hsl triplets', function (): void {
    foreach (PortalTheme::lightPropertyGroups()['tailwind'] as $value) {
        expect($value)->toMatch('/^\d+(\.\d+)? \d+(\.\d+)?% \d+(\.\d+)?%$/');
    }

    foreach (PortalTheme::darkPropertyGroups()['tailwind'] as $value) {
        expect($value)->toMatch('/^\d+(\.\d+)? \d+(\.\d+)?% \d+(\.\d+)?%$/');
    }
});

test('portal css variables use hex colors', function (): void {
    foreach (PortalTheme::lightPropertyGroups()['portal'] as $value) {
        expect($value)->toMatch('/^#[0-9a-f]{6}$/');
    }

    foreach (PortalTheme::darkPropertyGroups()['portal'] as $value) {
        expect($value)->toMatch('/^#[0-9a-f]{6}$/');
    }
});

test('light portal theme includes core keys from portal layout defaults', function (): void {
    $light = PortalTheme::lightPropertyGroups();

    expect($light['portal'])->toHaveKeys([
        'portal-body-bg',
        'portal-accent',
        'portal-card-bg',
        'portal-text',
        'portal-header-bg',
    ]);

    expect($light['tailwind'])->toHaveKeys([
        'background',
        'foreground',
        'primary',
        'card',
        'border',
    ]);
});
