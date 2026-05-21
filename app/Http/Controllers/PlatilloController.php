<?php

namespace App\Http\Controllers;

use App\Models\Platillo;
use App\Models\Categoria;
use Illuminate\Http\Request;

class PlatilloController extends Controller
{
    /**
     * 1. LEER (Index): Muestra la lista de platillos con sus precios e inventario.
     */
    public function index()
    {
        // Traemos los platillos con su categoría para mostrarla en la tabla
        $platillos = Platillo::with('categoria')->get();
        return view('admin.platillos.index', compact('platillos'));
    }

    /**
     * 2. CREAR (Formulario): Muestra la pantalla para añadir un nuevo platillo.
     */
    public function create()
    {
        // Traemos las categorías para llenar el select del formulario
        $categorias = Categoria::all();
        return view('admin.platillos.create', compact('categorias'));
    }

    /**
     * 3. GUARDAR (Store): Procesa el formulario y mete el platillo a la BD.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'precio' => 'required|numeric|min:0',
            'categoria_id' => 'required|exists:categorias,id',
        ]);

        // Por defecto al crearse, 'disponible' será 1 (true) debido a la BD
        Platillo::create($request->all());

        return redirect()->route('admin.platillos.index')->with('success', 'Platillo creado exitosamente.');
    }

    /**
     * El método show no lo necesitaremos por ahora, lo dejamos vacío.
     */
    public function show(Platillo $platillo)
    {
        //
    }

    /**
     * 4. EDITAR (Formulario): Muestra los datos actuales para cambiar precio/descripción.
     */
    public function edit(Platillo $platillo)
    {
        $categorias = Categoria::all();
        return view('admin.platillos.edit', compact('platillo', 'categorias'));
    }

    /**
     * 5. ACTUALIZAR (Update): Guarda los cambios de precio, descripción o disponibilidad.
     */
    public function update(Request $request, Platillo $platillo)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'precio' => 'required|numeric|min:0',
            'categoria_id' => 'required|exists:categorias,id',
            'disponible' => 'required|boolean', // Captura el estado del checkbox/select
        ]);

        $platillo->update($request->all());

        return redirect()->route('admin.platillos.index')->with('success', 'Platillo actualizado correctamente.');
    }

    /**
     * 6. BORRAR (Destroy): Elimina el platillo por completo.
     */
    public function destroy(Platillo $platillo)
    {
        $platillo->delete();
        return redirect()->route('admin.platillos.index')->with('success', 'Platillo eliminado del menú.');
    }

    /**
     * 7. FUNCIÓN EXTRA (Toggle): Botón rápido en la tabla para alternar disponibilidad (Boolean)
     */
    public function toggleDisponibilidad(Platillo $platillo)
    {
        $platillo->disponible = !$platillo->disponible;
        $platillo->save();

        return redirect()->back()->with('success', 'Estado de disponibilidad modificado.');
    }
}