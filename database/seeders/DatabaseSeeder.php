<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'cocinero@example.com'],
            [
                'name' => 'Barra Dream Garden',
                'password' => Hash::make('password'),
                'role' => User::ROLE_COCINERO,
            ]
        );

        User::updateOrCreate(
            ['email' => 'cliente@example.com'],
            [
                'name' => 'Cliente Dream Garden',
                'password' => Hash::make('password'),
                'role' => User::ROLE_CLIENTE,
            ]
        );

        $this->call(RestauranteSeeder::class);
    }
}
