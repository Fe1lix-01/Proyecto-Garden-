<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Categoria;
use App\Models\Platillo;

class RestauranteSeede extends Seeder
{
    // Implementacion de datos prueba para probar la aplicacion con .json de prueba
    // usando la estructura del $fillable de cada modelo para asignar los datos a cada tabla
    
    // Para ejecutarlo usar "php artisan db:seed --class=RestauranteSeeder"
    public function run(): void
    {
        // Categoria de Bebidas
        $bebidas = Categoria::create([
            'categoria' => 'Bebidas',
            'descripcion' => 'Refrescos y jugos naturales'
        ]);

        Platillo::create([
            'nombre' => 'Naranjada',
            'descripcion' => 'Jugo de naranja natural',
            'precio' => 18.00,
            'disponible' => true,
            'categoria_id' => $bebidas->id
        ]);

        Platillo::create([
            'nombre' => 'Coca-cola',
            'descripcion' => 'Refresco de cola',
            'precio' => 21.00,
            'disponible' => true,
            'categoria_id' => $bebidas->id
        ]);

        Platillo::create([
            'nombre' => 'Limonada',
            'descripcion' => 'Jugo de limón natural',
            'precio' => 18.00,
            'disponible' => true,
            'categoria_id' => $bebidas->id
        ]);

        // Categoria de entradas
        $entrada = Categoria::create([
            'categoria' => 'Entradas',
            'descripcion' => 'Platos de entrada para comenzar tu comida'
        ]);

        Platillo::create([
            'nombre' => 'Ensalada César',
            'descripcion' => 'Ensalada con pollo a la parrilla y aderezo César',
            'precio' => 100.00,
            'disponible' => true,
            'categoria_id' => $entrada->id
        ]);

        Platillo::create([
            'nombre' => 'Sopa de tortilla',
            'descripcion' => 'Sopa de tortilla con verduras',
            'precio' => 60.00,
            'disponible' => true,
            'categoria_id' => $entrada->id
        ]);

         // Categoria de postres
        $postre = Categoria::create([
            'categoria' => 'Postres',
            'descripcion' => 'Deliciosos postres para terminar tu comida'
        ]);

        Platillo::create([
            'nombre' => 'Pay de queso',
            'descripcion' => 'Postre de queso con salsa de frutas',
            'precio' => 40.00,
            'disponible' => true,
            'categoria_id' => $postre->id
        ]);

        Platillo::create([
            'nombre' => 'Flan',
            'descripcion' => 'Postre de caramelo con leche condensada',
            'precio' => 35.00,
            'disponible' => true,
            'categoria_id' => $postre->id
        ]);

    }
}
