<?php

declare(strict_types=1);

namespace App\Modules\Status\Requests;

use Closure;
use App\Support\Status\Status;
use Illuminate\Validation\Rule;
use App\Support\Status\StatusType;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Http\FormRequest;

class StatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, \Illuminate\Contracts\Validation\Rule|\Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $routeStatus = $this->route( 'status' );
        $statusId    = $routeStatus instanceof Status ? $routeStatus->getKey() : null;

        $typeInput = $this->input( 'type' );
        $type      = is_string( $typeInput ) ? $typeInput : '';

        return [
            'type' => ['required', 'string', 'max:40', Rule::in( $this->typeValues() )],
            'key'  => [
                'required',
                'string',
                'max:40',
                'alpha_dash',
                Rule::unique( 'statuses', 'key' )
                    ->where( static fn ( Builder $query ): Builder => $query->where( 'type', $type ) )
                    ->ignore( $statusId ),
            ],
            'parent_id' => [
                Rule::requiredIf( $type !== StatusType::Module->value ),
                'nullable',
                'integer',
                Rule::exists( 'statuses', 'id' )->where(
                    static fn ( Builder $query ): Builder => $query->where( 'type', StatusType::Module->value )
                ),
                function ( string $attribute, mixed $value, Closure $fail ) use ( $type, $statusId ): void {
                    if ( $type === StatusType::Module->value ) {
                        if ( filled( $value ) ) {
                            $fail( __( 'ui.module_type_cannot_have_a_parent_status' ) );
                        }

                        return;
                    }

                    if ( ! is_numeric( $value ) ) {
                        return;
                    }

                    $parent = Status::query()
                        ->select( ['id', 'key'] )
                        ->find( (int) $value );

                    if ( ! $parent instanceof Status ) {
                        return;
                    }

                    if ( (string) $parent->key !== $type ) {
                        $fail( __( 'ui.parent_module_must_match_the_selected_type' ) );
                    }

                    if ( is_numeric( $statusId ) && $parent->getKey() == $statusId ) {
                        $fail( __( 'ui.parent_status_cannot_reference_itself' ) );
                    }
                },
            ],
            'name_en' => ['required', 'string', 'max:120'],
            'name_ms' => ['required', 'string', 'max:120'],
        ];
    }

    /**
     * @return list<string>
     */
    private function typeValues(): array
    {
        return array_map( static fn ( StatusType $type ): string => $type->value, StatusType::cases() );
    }
}
