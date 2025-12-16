<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Models\User;
use App\Models\Admin;
use App\Models\Pelanggan;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
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
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'role' => fake()->randomElement(['pelanggan', 'admin']),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure(): static
    {
        return $this->afterCreating(function (User $user) {
            if ($user->role === 'pelanggan') {
                Pelanggan::factory()->create(['user_id' => $user->id]);
            } elseif ($user->role === 'admin') {
                Admin::factory()->create(['user_id' => $user->id]);
            }
        });
    }

        /**
         * Helper state untuk membuat user pelanggan
         *
         * @return $this
         */
        public function pelanggan(): static
        {
            return $this->state(fn (array $attributes) => [
                'role' => 'pelanggan',
            ]);
        }
    
        /**
         * Helper state untuk membuat user admin
         *
         * @return $this
         */
        public function admin(): static
        {
            return $this->state(fn (array $attributes) => [
                'role' => 'admin',
            ]);
        }
}
