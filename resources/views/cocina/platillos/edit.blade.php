<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="mb-2 text-xs font-black uppercase tracking-[0.25em] text-[#b02f00]">Editar producto</p>
                <h2 class="gf-title">{{ $platillo->nombre }}</h2>
                <p class="gf-subtitle mt-2">Actualiza datos y disponibilidad.</p>
            </div>

            <a href="{{ route('cocina.platillos.index') }}" class="gf-button-outline">
                Volver
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
            <form action="{{ route('cocina.platillos.update', $platillo) }}" method="POST" enctype="multipart/form-data" class="gf-card space-y-5 p-6">
                @csrf
                @method('PUT')

                <div>
                    <x-input-label for="nombre" value="Nombre" />
                    <input id="nombre" name="nombre" type="text" class="gf-input mt-1" value="{{ old('nombre', $platillo->nombre) }}" required autofocus>
                    <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="categoria_id" value="Categoria" />
                    <select id="categoria_id" name="categoria_id" required class="gf-input mt-1">
                        @foreach($categorias as $categoria)
                            <option value="{{ $categoria->id }}" @selected(old('categoria_id', $platillo->categoria_id) == $categoria->id)>
                                {{ $categoria->categoria }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('categoria_id')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="descripcion" value="Descripcion" />
                    <textarea id="descripcion" name="descripcion" rows="4" required class="gf-input mt-1">{{ old('descripcion', $platillo->descripcion) }}</textarea>
                    <x-input-error :messages="$errors->get('descripcion')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="precio" value="Precio" />
                    <input id="precio" name="precio" type="number" min="0" step="0.01" class="gf-input mt-1" value="{{ old('precio', $platillo->precio) }}" required>
                    <x-input-error :messages="$errors->get('precio')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="disponible" value="Disponibilidad" />
                    <select id="disponible" name="disponible" required class="gf-input mt-1">
                        <option value="1" @selected(old('disponible', $platillo->disponible) == 1)>Disponible</option>
                        <option value="0" @selected(old('disponible', $platillo->disponible) == 0)>Agotado</option>
                    </select>
                    <x-input-error :messages="$errors->get('disponible')" class="mt-2" />
                </div>

                @php
                    $imagenActual = $platillo->imagen ? asset('uploads/'.$platillo->imagen) : asset('img/garden.jpeg');
                @endphp

                <div class="grid grid-cols-1 gap-4 rounded-xl border border-[#e4e2e0] bg-[#f5f3f1] p-4 md:grid-cols-[180px_1fr]">
                    <div class="overflow-hidden rounded-xl bg-[#30302f]">
                        <img src="{{ $imagenActual }}" alt="Imagen actual de {{ $platillo->nombre }}" class="h-40 w-full object-cover md:h-full">
                    </div>
                    <div>
                        <x-input-label for="imagen" value="Cambiar imagen" />
                        <input id="imagen" name="imagen" type="file" accept="image/jpeg,image/png,image/webp" class="gf-input mt-2">
                        <p class="mt-2 text-xs font-semibold text-[#5b4039]">Si no subes un archivo nuevo, se conserva la imagen actual.</p>
                        <x-input-error :messages="$errors->get('imagen')" class="mt-2" />

                        <div class="mt-4">
                            <x-input-label for="imagen_existente" value="Imagen en public/uploads" />
                            <input id="imagen_existente" name="imagen_existente" type="text" class="gf-input mt-1" value="{{ old('imagen_existente', $platillo->imagen) }}" placeholder="cubano.jpg">
                            <p class="mt-2 text-xs font-semibold text-[#5b4039]">Escribe el nombre del archivo si ya lo pusiste manualmente en uploads.</p>
                            <x-input-error :messages="$errors->get('imagen_existente')" class="mt-2" />
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-3 border-t border-[#e4e2e0] pt-5">
                    <a href="{{ route('cocina.platillos.index') }}" class="gf-button-outline">
                        Cancelar
                    </a>
                    <button type="submit" class="gf-button-primary">
                        Actualizar
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
