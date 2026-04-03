<?php

declare(strict_types=1);

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class NoScript implements ValidationRule
{
    /**
     * Patterns that indicate potentially malicious script injection.
     *
     * @var array<string>
     */
    protected array $patterns = [
        '/<script\b[^>]*>.*?<\/script>/is',
        '/<script\b[^>]*>/is',
        '/javascript\s*:/is',
        '/on\w+\s*=/is',
        '/<iframe\b[^>]*>/is',
        '/<object\b[^>]*>/is',
        '/<embed\b[^>]*>/is',
        '/<link\b[^>]*>/is',
        '/<meta\b[^>]*>/is',
        '/<style\b[^>]*>.*?<\/style>/is',
        '/expression\s*\(/is',
        '/url\s*\(\s*["\']?\s*javascript:/is',
    ];

    /**
     * Run the validation rule.
     *
     * @param  Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate( string $attribute, mixed $value, Closure $fail ): void
    {
        if ( ! is_string( $value ) ) {
            return;
        }

        foreach ( $this->patterns as $pattern ) {
            if ( preg_match( $pattern, $value ) ) {
                $fail( __( 'ui.the_attribute_field_contains_potentially_dangerous_content' ) );

                return;
            }
        }
    }
}
