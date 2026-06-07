<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Platillo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PlatilloController extends Controller
{
    public function index(): View
    {
        $platillos = Platillo::with('categoria')
            ->orderBy('nombre')
            ->get();

        return view('cocina.platillos.index', compact('platillos'));
    }

    public function create(): View
    {
        $categorias = Categoria::orderBy('categoria')->get();

        return view('cocina.platillos.create', compact('categorias'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'descripcion' => ['required', 'string'],
            'precio' => ['required', 'numeric', 'min:0'],
            'categoria_id' => ['required', 'exists:categorias,id'],
        ]);

        $validated['disponible'] = true;

        Platillo::create($validated);

        return redirect()
            ->route('cocina.platillos.index')
            ->with('success', 'Platillo creado correctamente.');
    }

    public function edit(Platillo $platillo): View
    {
        $categorias = Categoria::orderBy('categoria')->get();

        return view('cocina.platillos.edit', compact('platillo', 'categorias'));
    }

    public function update(Request $request, Platillo $platillo): RedirectResponse
    {
        $validated = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'descripcion' => ['required', 'string'],
            'precio' => ['required', 'numeric', 'min:0'],
            'categoria_id' => ['required', 'exists:categorias,id'],
            'disponible' => ['required', 'boolean'],
        ]);

        $platillo->update($validated);

        return redirect()
            ->route('cocina.platillos.index')
            ->with('success', 'Platillo actualizado correctamente.');
    }

    public function destroy(Platillo $platillo): RedirectResponse
    {
        $platillo->delete();

        return redirect()
            ->route('cocina.platillos.index')
            ->with('success', 'Platillo eliminado del menu.');
    }

    public function toggleDisponibilidad(Platillo $platillo): RedirectResponse
    {
        $platillo->update(['disponible' => ! $platillo->disponible]);

        return redirect()
            ->route('cocina.platillos.index')
            ->with('success', 'Disponibilidad actualizada.');
    }
}
