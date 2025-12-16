<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Membuat 1 admin utama
        User::factory()->admin()->create([
            'name' => 'Admin Utama',
            'email' => 'admin@batitune.com',
            'password' => Hash::make('password123'), // Ganti dengan password yang kuat
        ]);

        // Membuat beberapa user admin tambahan
        User::factory()->admin()->count(2)->create();

        // Membuat beberapa user pelanggan
        User::factory()->pelanggan()->count(10)->create();

         // Membuat 1 pelanggan utama untuk testing
        User::factory()->pelanggan()->create([
            'name' => 'Pelanggan Test',
            'email' => 'pelanggan@example.com',
            'password' => Hash::make('password123'),
        ]);
    }
}