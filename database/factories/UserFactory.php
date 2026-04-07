<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Modules\User\Models\User;
use App\Modules\Role\Constants\RoleNameConstants;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Modules\User\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<User>
     */
    protected $model = User::class;

    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'              => fake()->name(),
            'email'             => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'approved_at'       => now(),
            'remember_token'    => Str::random( 10 ),
        ];
    }

    /**
     * Configure the model factory.
     */
    public function configure(): static
    {
        return $this->afterCreating( function ( User $user ): void {
            $user->storePassword( static::$password ??= 'password' );
        } );
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state( fn ( array $attributes ) => [
            'email_verified_at' => null,
        ] );
    }

    /**
     * Self-registration pending admin approval (no Spatie roles until approved).
     */
    public function pendingRegistration(): static
    {
        return $this->state( fn ( array $attributes ) => [
            'approved_at'      => null,
            'requested_role'   => RoleNameConstants::EDITOR,
            'rejected_at'      => null,
        ] );
    }
}
