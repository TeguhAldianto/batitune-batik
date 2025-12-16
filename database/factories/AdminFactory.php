<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Admin>
 */
class AdminFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // user_id akan diisi oleh UserFactory->configure() atau secara manual di seeder jika perlu
            // 'user_id' => User::factory()->admin(), // Hindari infinite loop
            'jabatan_admin' => fake()->randomElement(['Supervisor', 'Staff IT', 'Manajer Operasional']),
        ];
    }
}