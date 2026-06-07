<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\DetalleOrden;
use App\Models\Orden;
use App\Models\Platillo;
use App\Models\User;
use Illuminate\Database\Seeder;

class RestauranteSeeder extends Seeder
{
    public function run(): void
    {
        $bebidas = Categoria::create([
            'categoria' => 'Bebidas',
            'descripcion' => 'Cocteles preparados de 500 ml y 1 litro.',
        ]);

        $promociones = Categoria::create([
            'categoria' => 'Promociones',
            'descripcion' => 'Combos de bebidas, cervezas y vitroleros para compartir.',
        ]);

        $botellas = Categoria::create([
            'categoria' => 'Botellas',
            'descripcion' => 'Botellas populares en bares de Mexico.',
        ]);

        $comida = Categoria::create([
            'categoria' => 'Comida',
            'descripcion' => 'Comida casual para acompanar las bebidas.',
        ]);

        $extras = Categoria::create([
            'categoria' => 'Extras',
            'descripcion' => 'Articulos extra disponibles en Dream Garden Polanco.',
        ]);

        $platillos = collect([
            ['Cubano 500 ml', 'Bebida preparada sabor Cubano en vaso de 500 ml.', 50.00, $bebidas->id],
            ['Jackie Chan 500 ml', 'Bebida preparada sabor Jackie Chan en vaso de 500 ml.', 50.00, $bebidas->id],
            ['Diablo 500 ml', 'Bebida preparada sabor Diablo en vaso de 500 ml.', 50.00, $bebidas->id],
            ['Linterna Verde 500 ml', 'Bebida preparada sabor Linterna Verde en vaso de 500 ml.', 50.00, $bebidas->id],
            ['Azulito 500 ml', 'Bebida preparada sabor Azulito en vaso de 500 ml.', 50.00, $bebidas->id],
            ['Mango 500 ml', 'Bebida preparada sabor Mango en vaso de 500 ml.', 50.00, $bebidas->id],
            ['Cubano 1 litro', 'Bebida preparada sabor Cubano en presentacion de 1 litro.', 80.00, $bebidas->id],
            ['Jackie Chan 1 litro', 'Bebida preparada sabor Jackie Chan en presentacion de 1 litro.', 80.00, $bebidas->id],
            ['Diablo 1 litro', 'Bebida preparada sabor Diablo en presentacion de 1 litro.', 80.00, $bebidas->id],
            ['Linterna Verde 1 litro', 'Bebida preparada sabor Linterna Verde en presentacion de 1 litro.', 80.00, $bebidas->id],
            ['Azulito 1 litro', 'Bebida preparada sabor Azulito en presentacion de 1 litro.', 80.00, $bebidas->id],
            ['Mango 1 litro', 'Bebida preparada sabor Mango en presentacion de 1 litro.', 80.00, $bebidas->id],
            ['Promo 2 bebidas de 500 ml', 'Elige dos bebidas preparadas de 500 ml.', 80.00, $promociones->id],
            ['Promo 2 bebidas de 1 litro', 'Elige dos bebidas preparadas de 1 litro.', 140.00, $promociones->id],
            ['Cubeta de cervezas', 'Cubeta de cervezas para compartir.', 180.00, $promociones->id],
            ['Cerveza 355 ml', 'Cerveza individual de 355 ml.', 35.00, $promociones->id],
            ['Vitrolero', 'Vitrolero de 4 litros del sabor de bebida que el cliente elija.', 360.00, $promociones->id],
            ['Don Julio 70', 'Botella de tequila Don Julio 70.', 2200.00, $botellas->id],
            ['Maestro Dobel Diamante', 'Botella de tequila Maestro Dobel Diamante.', 1900.00, $botellas->id],
            ['Jose Cuervo Tradicional', 'Botella de tequila Jose Cuervo Tradicional.', 1200.00, $botellas->id],
            ['Patron Reposado', 'Botella de tequila Patron Reposado.', 2100.00, $botellas->id],
            ['Buchanans 12', 'Botella de whisky Buchanans 12.', 1900.00, $botellas->id],
            ['Johnnie Walker Black Label', 'Botella de whisky Johnnie Walker Black Label.', 1800.00, $botellas->id],
            ['Jack Daniels', 'Botella de whiskey Jack Daniels.', 1500.00, $botellas->id],
            ['Bacardi Blanco', 'Botella de ron Bacardi Blanco.', 900.00, $botellas->id],
            ['Captain Morgan', 'Botella de ron Captain Morgan.', 950.00, $botellas->id],
            ['Absolut Vodka', 'Botella de vodka Absolut.', 1100.00, $botellas->id],
            ['Pizza', 'Pizza completa para compartir.', 140.00, $comida->id],
            ['Boneless', 'Boneless con aderezo de la casa.', 140.00, $comida->id],
            ['Papas a la francesa', 'Orden de papas a la francesa.', 80.00, $comida->id],
            ['Maruchan', 'Sopa Maruchan preparada.', 30.00, $comida->id],
            ['Cigarro', 'Cigarro individual.', 15.00, $extras->id],
            ['Vape', 'Vape disponible en barra.', 200.00, $extras->id],
        ])->mapWithKeys(function (array $platillo) {
            $modelo = Platillo::create([
                'nombre' => $platillo[0],
                'descripcion' => $platillo[1],
                'precio' => $platillo[2],
                'disponible' => true,
                'categoria_id' => $platillo[3],
            ]);

            return [$modelo->nombre => $modelo];
        });

        $cliente = User::where('role', User::ROLE_CLIENTE)->first();

        if (! $cliente) {
            return;
        }

        $this->crearOrden($cliente, Orden::ESTADO_PENDIENTE, [
            [$platillos['Cubano 500 ml'], 2],
            [$platillos['Boneless'], 1],
        ]);

        $this->crearOrden($cliente, Orden::ESTADO_EN_PREPARACION, [
            [$platillos['Promo 2 bebidas de 1 litro'], 1],
            [$platillos['Papas a la francesa'], 1],
        ]);

        $this->crearOrden($cliente, Orden::ESTADO_LISTA, [
            [$platillos['Cerveza 355 ml'], 3],
            [$platillos['Pizza'], 1],
        ]);
    }

    private function crearOrden(User $cliente, string $estado, array $items): void
    {
        $orden = Orden::create([
            'user_id' => $cliente->id,
            'estado' => $estado,
            'total' => 0,
        ]);

        $total = 0;

        foreach ($items as [$platillo, $cantidad]) {
            $subtotal = $platillo->precio * $cantidad;
            $total += $subtotal;

            DetalleOrden::create([
                'orden_id' => $orden->id,
                'platillo_id' => $platillo->id,
                'cantidad' => $cantidad,
                'precio_unitario' => $platillo->precio,
                'subtotal' => $subtotal,
            ]);
        }

        $orden->update(['total' => $total]);
    }
}
