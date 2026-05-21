<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Database\Seeders\RestauranteSeeder;


class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    // Comando para ejecutar el seeder:
    // php artisan migrate:fresh --seed
    public function run(): void
    {
        // Crear un usuario específico (Ideal para tu cuenta de Administrador/Pruebas)
        User::create([
            'name' => 'Cocinero',
            'email' => 'cocinero@gmail.com',
            'password' => Hash::make('admin123'), // SIEMPRE encripta la contraseña
            'role' => 'admin' // Asignamos el rol de admin para este usuario
        ]);

        // Crear otro usuario de prueba con datos distintos si lo necesitas
        User::create([
            'name' => 'Jorge',
            'email' => 'jorge@gmail.com',
            'password' => Hash::make('Lapapa123'),
        ]);

        // Llamar a tus otros seeders específicos
        $this->call([
            RestauranteSeede::class
            // Si tienes más, los vas agregando aquí separados por coma:
            // PlatillosSeeder::class,
        ]);
    }
}
