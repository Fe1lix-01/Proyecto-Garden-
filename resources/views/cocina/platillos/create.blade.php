<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <h2 class="text-xl font-bold leading-tight text-gray-900">Nuevo producto</h2>
                <p class="text-sm text-gray-500">Alta de productos para la carta de Dream Garden.</p>
            </div>

            <a href="{{ route('cocina.platillos.index') }}" class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm hover:bg-gray-50">
                Volver
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
            <form action="{{ route('cocina.platillos.store') }}" method="POST" class="space-y-5 rounded-md border border-gray-200 bg-white p-6 shadow-sm">
                @csrf

                <div>
                    <x-input-label for="nombre" value="Nombre" />
                    <x-text-input id="nombre" name="nombre" type="text" class="mt-1 block w-full" :value="old('nombre')" required autofocus />
                    <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="categoria_id" value="Categoria" />
                    <select id="categoria_id" name="categoria_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
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
                    <textarea id="descripcion" name="descripcion" rows="4" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('descripcion') }}</textarea>
                    <x-input-error :messages="$errors->get('descripcion')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="precio" value="Precio" />
                    <x-text-input id="precio" name="precio" type="number" min="0" step="0.01" class="mt-1 block w-full" :value="old('precio')" required />
                    <x-input-error :messages="$errors->get('precio')" class="mt-2" />
                </div>

                <div class="flex justify-end gap-3 border-t border-gray-100 pt-5">
                    <a href="{{ route('cocina.platillos.index') }}" class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm hover:bg-gray-50">
                        Cancelar
                    </a>
                    <button type="submit" class="inline-flex items-center justify-center rounded-md bg-emerald-700 px-4 py-2 text-sm font-bold text-white shadow-sm hover:bg-emerald-800">
                        Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
