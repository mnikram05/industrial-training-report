<?php

declare(strict_types=1);

namespace App\Modules\User\Concerns;

use Illuminate\Validation\Rule;
use App\Modules\User\Models\User;

trait ProfileValidationRules
{
    /**
     * Get the validation rules used to validate user profiles.
     *
     * @return array<string, array<int, \Illuminate\Contracts\Validation\ValidationRule|\Illuminate\Validation\Rules\Unique|array<mixed>|string>>
     */
    protected function profileRules( int|string|null $userId = null ): array
    {
        return [
            'name'  => $this->nameRules(),
            'email' => $this->emailRules( $userId ),
        ];
    }

    /**
     * Get the validation rules used to validate user names.
     *
     * @return array<int, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    protected function nameRules(): array
    {
        return ['required', 'string', 'max:255'];
    }

    /**
     * Get the validation rules used to validate user emails.
     *
     * @return array<int, \Illuminate\Validation\Rules\Unique|\Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    protected function emailRules( int|string|null $userId = null ): array
    {
        $unique = Rule::unique( User::class, 'email' )->whereNull( 'deleted_at' );

        return [
            'required',
            'string',
            'lowercase',
            'email',
            'max:255',
            $userId === null
                ? $unique
                : $unique->ignore( $userId ),
        ];
    }
}
