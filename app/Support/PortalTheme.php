<?php

declare(strict_types=1);

namespace App\Support;

use Modules\PortalAdministration\Models\PortalSetting;

final class PortalTheme
{
    /**
     * Defaults aligned with {@see \Modules\Portal\resources\views\layout.blade.php}.
     *
     * @var array<string, string>
     */
    private const DEFAULTS = [
        'color_header_bg' => '#0f172a',
        'color_hero_bg_from' => '#0f172a',
        'color_hero_bg_to' => '#1e293b',
        'color_accent' => '#f43f5e',
        'color_footer_bg' => '#0f172a',
        'color_body_bg' => '#f8fafc',
        'color_lang_active' => '#f43f5e',
        'color_card_bg' => '#ffffff',
        'color_text' => '#1f2937',
        'color_nav_bg' => '#f43f5e',
        'dark_header_bg' => '#020617',
        'dark_hero_bg_from' => '#020617',
        'dark_hero_bg_to' => '#0f172a',
        'dark_accent' => '#fb7185',
        'dark_footer_bg' => '#020617',
        'dark_body_bg' => '#0f172a',
        'dark_card_bg' => '#1e293b',
        'dark_text' => '#e2e8f0',
        'dark_nav_bg' => '#fb7185',
        'dark_lang_active' => '#fb7185',
    ];

    /**
     * @return array<string, string>
     */
    public static function rawColors(): array
    {
        $from = PortalSetting::forPage('header-footer');
        if ($from === []) {
            $from = PortalSetting::forPage('home');
        }

        $merged = self::DEFAULTS;
        foreach ($from as $key => $value) {
            if (is_string($value) && $value !== '') {
                $merged[$key] = $value;
            }
        }

        if (! isset($merged['color_nav_bg']) || $merged['color_nav_bg'] === '') {
            $merged['color_nav_bg'] = $merged['color_accent'];
        }
        if (! isset($merged['dark_nav_bg']) || $merged['dark_nav_bg'] === '') {
            $merged['dark_nav_bg'] = $merged['dark_accent'];
        }
        if (! isset($merged['dark_lang_active']) || $merged['dark_lang_active'] === '') {
            $merged['dark_lang_active'] = $merged['dark_accent'];
        }

        return $merged;
    }

    /**
     * CSS custom properties for the admin layout (after base app.css).
     *
     * @return array{portal: array<string, string>, tailwind: array<string, string>}
     */
    public static function lightPropertyGroups(): array
    {
        $c = self::rawColors();

        return [
            'portal' => [
                'portal-header-bg' => self::sanitizeHex($c['color_header_bg'], self::DEFAULTS['color_header_bg']),
                'portal-hero-from' => self::sanitizeHex($c['color_hero_bg_from'], self::DEFAULTS['color_hero_bg_from']),
                'portal-hero-to' => self::sanitizeHex($c['color_hero_bg_to'], self::DEFAULTS['color_hero_bg_to']),
                'portal-accent' => self::sanitizeHex($c['color_accent'], self::DEFAULTS['color_accent']),
                'portal-footer-bg' => self::sanitizeHex($c['color_footer_bg'], self::DEFAULTS['color_footer_bg']),
                'portal-body-bg' => self::sanitizeHex($c['color_body_bg'], self::DEFAULTS['color_body_bg']),
                'portal-lang-active' => self::sanitizeHex($c['color_lang_active'], self::DEFAULTS['color_lang_active']),
                'portal-card-bg' => self::sanitizeHex($c['color_card_bg'], self::DEFAULTS['color_card_bg']),
                'portal-text' => self::sanitizeHex($c['color_text'], self::DEFAULTS['color_text']),
                'portal-nav-bg' => self::sanitizeHex($c['color_nav_bg'], self::DEFAULTS['color_nav_bg']),
            ],
            'tailwind' => self::tailwindLightFromPortal($c),
        ];
    }

    /**
     * @return array{portal: array<string, string>, tailwind: array<string, string>}
     */
    public static function darkPropertyGroups(): array
    {
        $c = self::rawColors();

        return [
            'portal' => [
                'portal-header-bg' => self::sanitizeHex($c['dark_header_bg'], self::DEFAULTS['dark_header_bg']),
                'portal-hero-from' => self::sanitizeHex($c['dark_hero_bg_from'], self::DEFAULTS['dark_hero_bg_from']),
                'portal-hero-to' => self::sanitizeHex($c['dark_hero_bg_to'], self::DEFAULTS['dark_hero_bg_to']),
                'portal-accent' => self::sanitizeHex($c['dark_accent'], self::DEFAULTS['dark_accent']),
                'portal-footer-bg' => self::sanitizeHex($c['dark_footer_bg'], self::DEFAULTS['dark_footer_bg']),
                'portal-body-bg' => self::sanitizeHex($c['dark_body_bg'], self::DEFAULTS['dark_body_bg']),
                'portal-lang-active' => self::sanitizeHex($c['dark_lang_active'], self::DEFAULTS['dark_lang_active']),
                'portal-card-bg' => self::sanitizeHex($c['dark_card_bg'], self::DEFAULTS['dark_card_bg']),
                'portal-text' => self::sanitizeHex($c['dark_text'], self::DEFAULTS['dark_text']),
                'portal-nav-bg' => self::sanitizeHex($c['dark_nav_bg'], self::DEFAULTS['dark_nav_bg']),
            ],
            'tailwind' => self::tailwindDarkFromPortal($c),
        ];
    }

    /**
     * @param  array<string, string>  $c
     * @return array<string, string>
     */
    private static function tailwindLightFromPortal(array $c): array
    {
        $body = self::sanitizeHex($c['color_body_bg'], self::DEFAULTS['color_body_bg']);
        $text = self::sanitizeHex($c['color_text'], self::DEFAULTS['color_text']);
        $card = self::sanitizeHex($c['color_card_bg'], self::DEFAULTS['color_card_bg']);
        $accent = self::sanitizeHex($c['color_accent'], self::DEFAULTS['color_accent']);

        $bgHsl = self::hexToHslComponents($body);
        $textHsl = self::hexToHslComponents($text);
        $cardHsl = self::hexToHslComponents($card);
        $accentHsl = self::hexToHslComponents($accent);

        $mutedHsl = self::adjustHsl($bgHsl, lDelta: -3.5, sDelta: -4);
        $borderHsl = self::adjustHsl($bgHsl, lDelta: -8, sDelta: 5);
        $secondaryHsl = self::adjustHsl($bgHsl, lDelta: -2, sDelta: -8);
        $mutedFgHsl = self::adjustHsl($textHsl, lDelta: 18, sDelta: -35);
        $accentUiHsl = self::adjustHsl($bgHsl, lDelta: -1.5, sDelta: -6);

        return [
            'background' => self::formatHslTailwind($bgHsl),
            'foreground' => self::formatHslTailwind($textHsl),
            'card' => self::formatHslTailwind($cardHsl),
            'card-foreground' => self::formatHslTailwind($textHsl),
            'popover' => self::formatHslTailwind($cardHsl),
            'popover-foreground' => self::formatHslTailwind($textHsl),
            'primary' => self::formatHslTailwind($accentHsl),
            'primary-foreground' => self::contrastingForegroundHsl($accent),
            'secondary' => self::formatHslTailwind($secondaryHsl),
            'secondary-foreground' => self::formatHslTailwind($textHsl),
            'muted' => self::formatHslTailwind($mutedHsl),
            'muted-foreground' => self::formatHslTailwind($mutedFgHsl),
            'accent' => self::formatHslTailwind($accentUiHsl),
            'accent-foreground' => self::formatHslTailwind($textHsl),
            'border' => self::formatHslTailwind($borderHsl),
            'input' => self::formatHslTailwind($borderHsl),
            'ring' => self::formatHslTailwind($accentHsl),
        ];
    }

    /**
     * @param  array<string, string>  $c
     * @return array<string, string>
     */
    private static function tailwindDarkFromPortal(array $c): array
    {
        $body = self::sanitizeHex($c['dark_body_bg'], self::DEFAULTS['dark_body_bg']);
        $text = self::sanitizeHex($c['dark_text'], self::DEFAULTS['dark_text']);
        $card = self::sanitizeHex($c['dark_card_bg'], self::DEFAULTS['dark_card_bg']);
        $accent = self::sanitizeHex($c['dark_accent'], self::DEFAULTS['dark_accent']);

        $bgHsl = self::hexToHslComponents($body);
        $textHsl = self::hexToHslComponents($text);
        $cardHsl = self::hexToHslComponents($card);
        $accentHsl = self::hexToHslComponents($accent);

        $mutedHsl = self::adjustHsl($bgHsl, lDelta: 6, sDelta: -5);
        $borderHsl = self::adjustHsl($bgHsl, lDelta: 12, sDelta: -8);
        $secondaryHsl = self::adjustHsl($cardHsl, lDelta: -4, sDelta: 0);
        $mutedFgHsl = self::adjustHsl($textHsl, lDelta: -18, sDelta: -25);
        $accentUiHsl = self::adjustHsl($cardHsl, lDelta: 3, sDelta: -5);

        return [
            'background' => self::formatHslTailwind($bgHsl),
            'foreground' => self::formatHslTailwind($textHsl),
            'card' => self::formatHslTailwind($cardHsl),
            'card-foreground' => self::formatHslTailwind($textHsl),
            'popover' => self::formatHslTailwind($cardHsl),
            'popover-foreground' => self::formatHslTailwind($textHsl),
            'primary' => self::formatHslTailwind($accentHsl),
            'primary-foreground' => self::contrastingForegroundHsl($accent),
            'secondary' => self::formatHslTailwind($secondaryHsl),
            'secondary-foreground' => self::formatHslTailwind($textHsl),
            'muted' => self::formatHslTailwind($mutedHsl),
            'muted-foreground' => self::formatHslTailwind($mutedFgHsl),
            'accent' => self::formatHslTailwind($accentUiHsl),
            'accent-foreground' => self::formatHslTailwind($textHsl),
            'border' => self::formatHslTailwind($borderHsl),
            'input' => self::formatHslTailwind($borderHsl),
            'ring' => self::formatHslTailwind($accentHsl),
        ];
    }

    private static function contrastingForegroundHsl(string $hex): string
    {
        $luminance = self::relativeLuminance($hex);

        return $luminance > 0.45 ? '222.2 47.4% 11.2%' : '0 0% 100%';
    }

    private static function relativeLuminance(string $hex): float
    {
        $hex = ltrim(self::sanitizeHex($hex, '#000000'), '#');
        if (strlen($hex) === 3) {
            $hex = $hex[0].$hex[0].$hex[1].$hex[1].$hex[2].$hex[2];
        }

        $r = hexdec(substr($hex, 0, 2)) / 255;
        $g = hexdec(substr($hex, 2, 2)) / 255;
        $b = hexdec(substr($hex, 4, 2)) / 255;

        $linearize = static fn (float $c): float => $c <= 0.03928 ? $c / 12.92 : (($c + 0.055) / 1.055) ** 2.4;

        $R = $linearize($r);
        $G = $linearize($g);
        $B = $linearize($b);

        return 0.2126 * $R + 0.7152 * $G + 0.0722 * $B;
    }

    /**
     * @return array{0: float, 1: float, 2: float} h [0,360), s [0,100], l [0,100]
     */
    private static function hexToHslComponents(string $hex): array
    {
        $hex = ltrim(self::sanitizeHex($hex, '#808080'), '#');
        if (strlen($hex) === 3) {
            $hex = $hex[0].$hex[0].$hex[1].$hex[1].$hex[2].$hex[2];
        }

        $r = hexdec(substr($hex, 0, 2)) / 255;
        $g = hexdec(substr($hex, 2, 2)) / 255;
        $b = hexdec(substr($hex, 4, 2)) / 255;

        $max = max($r, $g, $b);
        $min = min($r, $g, $b);
        $l = ($max + $min) / 2;

        if (abs($max - $min) < 0.00001) {
            return [0.0, 0.0, $l * 100];
        }

        $d = $max - $min;
        $s = $l > 0.5 ? $d / (2 - $max - $min) : $d / ($max + $min);

        $h = match ($max) {
            $r => fmod((($g - $b) / $d + ($g < $b ? 6 : 0)) / 6, 1) * 360,
            $g => ((($b - $r) / $d) + 2) / 6 * 360,
            default => ((($r - $g) / $d) + 4) / 6 * 360,
        };

        return [$h, $s * 100, $l * 100];
    }

    /**
     * @param  array{0: float, 1: float, 2: float}  $hsl
     * @return array{0: float, 1: float, 2: float}
     */
    private static function adjustHsl(array $hsl, float $hDelta = 0, float $sDelta = 0, float $lDelta = 0): array
    {
        $h = fmod($hsl[0] + $hDelta + 360, 360);
        $s = max(0, min(100, $hsl[1] + $sDelta));
        $l = max(0, min(100, $hsl[2] + $lDelta));

        return [$h, $s, $l];
    }

    /**
     * @param  array{0: float, 1: float, 2: float}  $hsl
     */
    private static function formatHslTailwind(array $hsl): string
    {
        return sprintf('%.4f %.4f%% %.4f%%', $hsl[0], $hsl[1], $hsl[2]);
    }

    private static function sanitizeHex(string $value, string $fallback): string
    {
        $v = trim($value);
        if (preg_match('/^#([0-9A-Fa-f]{3})$/', $v) === 1) {
            $h = substr($v, 1);

            return strtolower(sprintf('#%s%s%s%s%s%s', $h[0], $h[0], $h[1], $h[1], $h[2], $h[2]));
        }

        if (preg_match('/^#([0-9A-Fa-f]{6})$/', $v) === 1) {
            return strtolower($v);
        }

        return strtolower($fallback);
    }
}
