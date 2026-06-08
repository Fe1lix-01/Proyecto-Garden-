<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Platillo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class PlatilloController extends Controller
{
    public function index(Request $request): View
    {
        $categoriaActual = $request->integer('categoria');
        $categorias = Categoria::orderBy('categoria')->get();

        $platillos = Platillo::with('categoria')
            ->when($categoriaActual > 0, fn ($query) => $query->where('categoria_id', $categoriaActual))
            ->orderBy('nombre')
            ->get();

        return view('cocina.platillos.index', compact('platillos', 'categorias', 'categoriaActual'));
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
            'imagen' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'imagen_existente' => ['nullable', 'string', 'max:255'],
        ]);

        $validated['disponible'] = true;
        $imagen = $this->resolverImagen($request);

        if ($imagen !== null) {
            $validated['imagen'] = $imagen;
        }

        unset($validated['imagen_existente']);

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
            'imagen' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'imagen_existente' => ['nullable', 'string', 'max:255'],
        ]);

        $imagen = $this->resolverImagen($request);

        if ($imagen !== null) {
            $validated['imagen'] = $imagen;
        }

        unset($validated['imagen_existente']);

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

        return back()
            ->with('success', 'Disponibilidad actualizada.');
    }

    private function resolverImagen(Request $request): ?string
    {
        if ($request->hasFile('imagen')) {
            $archivo = $request->file('imagen');
            $nombreBase = Str::slug(pathinfo($archivo->getClientOriginalName(), PATHINFO_FILENAME)) ?: 'producto';
            $nombreArchivo = $nombreBase.'-'.Str::uuid().'.'.$archivo->getClientOriginalExtension();
            $destino = $this->asegurarCarpetaUploads();

            $archivo->move($destino, $nombreArchivo);

            return $nombreArchivo;
        }

        $imagenExistente = trim((string) $request->input('imagen_existente'));

        if ($imagenExistente === '') {
            return null;
        }

        $ruta = parse_url($imagenExistente, PHP_URL_PATH) ?: $imagenExistente;
        $nombreArchivo = basename($ruta);
        $rutaPublica = public_path('uploads/'.$nombreArchivo);
        $rutaRaiz = base_path('uploads/'.$nombreArchivo);

        if (file_exists($rutaPublica)) {
            return $nombreArchivo;
        }

        if (file_exists($rutaRaiz)) {
            copy($rutaRaiz, $this->asegurarCarpetaUploads().DIRECTORY_SEPARATOR.$nombreArchivo);

            return $nombreArchivo;
        }

        if (! file_exists($rutaPublica)) {
            throw ValidationException::withMessages([
                'imagen_existente' => 'No encontre esa imagen dentro de public/uploads ni uploads.',
            ]);
        }

        return $nombreArchivo;
    }

    private function asegurarCarpetaUploads(): string
    {
        $destino = public_path('uploads');

        if (! is_dir($destino)) {
            mkdir($destino, 0755, true);
        }

        return $destino;
    }
}
