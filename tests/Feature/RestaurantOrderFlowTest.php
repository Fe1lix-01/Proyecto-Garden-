<?php

namespace Tests\Feature;

use App\Models\Categoria;
use App\Models\Orden;
use App\Models\Platillo;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RestaurantOrderFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_cliente_crea_orden_con_detalles_y_total_calculado(): void
    {
        $cliente = User::factory()->create(['role' => User::ROLE_CLIENTE]);
        $categoria = Categoria::create([
            'categoria' => 'Pizzas',
            'descripcion' => 'Pizzas artesanales',
        ]);
        $platillo = Platillo::create([
            'nombre' => 'Pizza margarita',
            'descripcion' => 'Salsa, queso y albahaca',
            'precio' => 120,
            'disponible' => true,
            'categoria_id' => $categoria->id,
        ]);

        $response = $this
            ->actingAs($cliente)
            ->withSession([
                'carrito' => [
                    $platillo->id => [
                        'id' => $platillo->id,
                        'nombre' => $platillo->nombre,
                        'cantidad' => 2,
                        'precio' => 120,
                    ],
                ],
            ])
            ->post(route('cliente.ordenes.store'));

        $response->assertRedirect(route('cliente.ordenes.index'));

        $orden = Orden::first();

        $this->assertSame($cliente->id, $orden->user_id);
        $this->assertSame(Orden::ESTADO_PENDIENTE, $orden->estado);
        $this->assertSame('240.00', $orden->total);
        $this->assertDatabaseHas('detalle_orden', [
            'orden_id' => $orden->id,
            'platillo_id' => $platillo->id,
            'cantidad' => 2,
            'precio_unitario' => 120,
            'subtotal' => 240,
        ]);
    }

    public function test_cocinero_avanza_estado_de_orden(): void
    {
        $cocinero = User::factory()->create(['role' => User::ROLE_COCINERO]);
        $cliente = User::factory()->create(['role' => User::ROLE_CLIENTE]);
        $orden = Orden::create([
            'user_id' => $cliente->id,
            'estado' => Orden::ESTADO_PENDIENTE,
            'total' => 100,
        ]);

        $this->actingAs($cocinero)
            ->patch(route('cocina.ordenes.avanzar', $orden))
            ->assertRedirect(route('cocina.ordenes.index'));

        $this->assertSame(Orden::ESTADO_EN_PREPARACION, $orden->fresh()->estado);

        $this->actingAs($cocinero)
            ->patch(route('cocina.ordenes.avanzar', $orden))
            ->assertRedirect(route('cocina.ordenes.index'));

        $this->assertSame(Orden::ESTADO_LISTA, $orden->fresh()->estado);
    }

    public function test_cliente_solo_puede_cancelar_orden_pendiente_propia(): void
    {
        $cliente = User::factory()->create(['role' => User::ROLE_CLIENTE]);
        $orden = Orden::create([
            'user_id' => $cliente->id,
            'estado' => Orden::ESTADO_PENDIENTE,
            'total' => 100,
        ]);

        $this->actingAs($cliente)
            ->patch(route('cliente.ordenes.cancelar', $orden))
            ->assertRedirect(route('cliente.ordenes.index'));

        $this->assertSame(Orden::ESTADO_CANCELADA, $orden->fresh()->estado);
    }

    public function test_roles_restringen_secciones(): void
    {
        $cliente = User::factory()->create(['role' => User::ROLE_CLIENTE]);
        $cocinero = User::factory()->create(['role' => User::ROLE_COCINERO]);

        $this->actingAs($cliente)
            ->get(route('cocina.ordenes.index'))
            ->assertRedirect(route('dashboard'));

        $this->actingAs($cocinero)
            ->get(route('cliente.menu'))
            ->assertRedirect(route('dashboard'));
    }
}
