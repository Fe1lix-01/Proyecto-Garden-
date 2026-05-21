<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Categoria;
use App\Models\Platillo;
use App\Models\Orden;
use App\Models\DetalleOrden;
use App\Models\User;

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

        Platillo::create([
            'nombre' => 'Crepa de Nutella',
            'descripcion' => 'Crepa rellena de Nutella y fresas',
            'precio' => 55.00,
            'disponible' => true,
            'categoria_id' => $postre->id
        ]);



        //---Creación de Ordenes ---//

        $naranjada = Platillo::where('nombre', 'Naranjada')->first();
        $coca = Platillo::where('nombre', 'Coca-cola')->first();
        $limonada = Platillo::where('nombre', 'Limonada')->first();
        $ensalada = Platillo::where('nombre', 'Ensalada César')->first();
        $sopa = Platillo::where('nombre', 'Sopa de tortilla')->first();
        $pay = Platillo::where('nombre', 'Pay de queso')->first();
        $crepa = Platillo::where('nombre', 'Crepa de Nutella')->first();

        // Obtenemos el usuario que creamos en el DatabaseSeeder para ligar las órdenes
        $user = User::first(); 
        
        // Si por alguna razón corres este seeder solo y no hay usuarios, creamos uno de respaldo
        $userId = $user ? $user->id : User::create([
            'name' => 'Cliente Default',
            'email' => 'cliente@example.com',
            'password' => bcrypt('password123')
        ])->id;

        // ------- ÓRDEN 1: Una comida completa individual (Sopa + Crepa + Naranjada) -------
        // Total: 60.00 + 55.00 + 18.00 = 133.00
        $orden1 = Orden::create([
            'user_id' => $userId,
            'total' => 133.00,
            'estado' => 'pendiente', // Ajusta los estados según tus necesidades ('pendiente', 'en proceso')
        ]);

        DetalleOrden::create([
            'orden_id' => $orden1->id,
            'platillo_id' => $sopa->id,
            'cantidad' => 1,
            'precio' => $sopa->precio,
            'subtotal' => $sopa->precio * 1, // 60.00
        ]);

        DetalleOrden::create([
            'orden_id' => $orden1->id,
            'platillo_id' => $crepa->id,
            'cantidad' => 1,
            'precio' => $crepa->precio,
            'subtotal' => $crepa->precio * 1, // 55.00
        ]);

        DetalleOrden::create([
            'orden_id' => $orden1->id,
            'platillo_id' => $naranjada->id,
            'cantidad' => 1,
            'precio' => $naranjada->precio,
            'subtotal' => $naranjada->precio * 1, // 18.00
        ]);

        // ------- ÓRDEN 2: Solo bebidas y postre para dos personas (2 Cocas + 1 Pay de queso) -------
        // Total: (21.00 * 2) + 40.00 = 82.00
        $orden2 = Orden::create([
            'user_id' => $userId,
            'total' => 82.00,
            'estado' => 'en proceso',
        ]);

        DetalleOrden::create([
            'orden_id' => $orden2->id,
            'platillo_id' => $coca->id,
            'cantidad' => 2,
            'precio' => $coca->precio,
            'subtotal' => $coca->precio * 2, // 21.00 * 2 = 42.00
        ]);

        DetalleOrden::create([
            'orden_id' => $orden2->id,
            'platillo_id' => $pay->id,
            'cantidad' => 1,
            'precio' => $pay->precio,
            'subtotal' => $pay->precio * 1, // 40.00
        ]);


        // ------- ÓRDEN 3: Una comida ligera (Ensalada César + Limonada) -------
        // Total: 100.00 + 18.00 = 118.00
        $orden3 = Orden::create([
            'user_id' => $userId,
            'total' => 118.00,
            'estado' => 'pendiente',
        ]);

        DetalleOrden::create([
            'orden_id' => $orden3->id,
            'platillo_id' => $ensalada->id,
            'cantidad' => 1,
            'precio' => $ensalada->precio,
            'subtotal' => $ensalada->precio * 1, // 100.00
        ]);

        DetalleOrden::create([
            'orden_id' => $orden3->id,
            'platillo_id' => $limonada->id,
            'cantidad' => 1,
            'precio' => $limonada->precio,
            'subtotal' => $limonada->precio * 1, // 18.00
        ]);
    }
}
