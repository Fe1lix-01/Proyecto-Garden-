<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="mb-2 text-xs font-black uppercase tracking-[0.25em] text-[#b02f00]">Nuevo producto</p>
                <h2 class="gf-title">Alta de carta</h2>
                <p class="gf-subtitle mt-2">Agrega bebidas, promos, botellas, comida o extras.</p>
            </div>

            <a href="{{ route('cocina.platillos.index') }}" class="gf-button-outline">
                Volver
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
            <form action="{{ route('cocina.platillos.store') }}" method="POST" enctype="multipart/form-data" class="gf-card space-y-5 p-6">
                @csrf

                <div>
                    <x-input-label for="nombre" value="Nombre" />
                    <input id="nombre" name="nombre" type="text" class="gf-input mt-1" value="{{ old('nombre') }}" required autofocus>
                    <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="categoria_id" value="Categoria" />
                    <select id="categoria_id" name="categoria_id" required class="gf-input mt-1">
                        <option value="">Selecciona una categoria</option>
                        @foreach($categorias as $categoria)
                            <option value="{{ $categoria->id }}" @selected(old('categoria_id') == $categoria->id)>
                                {{ $categoria->categoria }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('categoria_id')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="descripcion" value="Descripcion" />
                    <textarea id="descripcion" name="descripcion" rows="4" required class="gf-input mt-1">{{ old('descripcion') }}</textarea>
                    <x-input-error :messages="$errors->get('descripcion')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="precio" value="Precio" />
                    <input id="precio" name="precio" type="number" min="0" step="0.01" class="gf-input mt-1" value="{{ old('precio') }}" required>
                    <x-input-error :messages="$errors->get('precio')" class="mt-2" />
                </div>

                <div class="rounded-xl border border-[#e4e2e0] bg-[#f5f3f1] p-4">
                    <x-input-label for="imagen" value="Imagen del producto" />
                    <input id="imagen" name="imagen" type="file" accept="image/jpeg,image/png,image/webp" class="gf-input mt-2">
                    <x-input-error :messages="$errors->get('imagen')" class="mt-2" />

                    <div class="mt-4">
                        <x-input-label for="imagen_existente" value="O usa una imagen que ya este en public/uploads" />
                        <input id="imagen_existente" name="imagen_existente" type="text" class="gf-input mt-1" value="{{ old('imagen_existente') }}" placeholder="cubano.jpg">
                        <p class="mt-2 text-xs font-semibold text-[#5b4039]">Puedes escribir solo el archivo o la ruta /uploads/archivo.jpg.</p>
                        <x-input-error :messages="$errors->get('imagen_existente')" class="mt-2" />
                    </div>
                </div>

                <div class="flex justify-end gap-3 border-t border-[#e4e2e0] pt-5">
                    <a href="{{ route('cocina.platillos.index') }}" class="gf-button-outline">
                        Cancelar
                    </a>
                    <button type="submit" class="gf-button-primary">
                        Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
