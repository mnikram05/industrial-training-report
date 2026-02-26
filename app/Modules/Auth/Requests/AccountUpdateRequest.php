<?php

declare(strict_types=1);

namespace App\Modules\Auth\Requests;

use Illuminate\Validation\Rule;
use App\Modules\User\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class AccountUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user() instanceof User;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $user = $this->user();
        $rule = Rule::unique( 'users', 'email' );

        if ( $user instanceof User ) {
            $rule = $rule->ignore( $user );
        }

        return [
            'name'  => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', $rule],
        ];
    }
}
