<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pelanggan>
 */
class PelangganFactory extends Factory
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
            // 'user_id' => User::factory()->pelanggan(), // Hindari infinite loop jika UserFactory memanggil PelangganFactory
            'no_hp' => fake()->unique()->e164PhoneNumber(),
        ];
    }
}
