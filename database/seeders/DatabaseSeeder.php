<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Panggil AdminSeeder
        $this->call([
            AdminSeeder::class,
            ProdukSeeder::class,
        ]);

        // Buat test user dengan role user
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'role' => 'user', // Tambahkan role
            'password' => Hash::make('password'), // Tambahkan password
        ]);

        // Opsional: Buat beberapa user acak
        // User::factory(10)->create();
    }
}