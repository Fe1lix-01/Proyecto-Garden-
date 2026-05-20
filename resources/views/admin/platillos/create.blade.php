<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Registrar Nuevo Platillo') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg" style="background-color: #ffffff !important;">
                <div class="p-6 border-b border-gray-200" style="background-color: #ffffff !important;">
                    
                    <form action="{{ route('admin.platillos.store') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label for="nombre" class="block text-gray-700 text-sm font-bold mb-2">Nombre del Platillo:</label>
                            <input type="text" name="nombre" id="nombre" value="{{ old('nombre') }}" 
                                style="color: #111827 !important; background-color: #ffffff !important; border: 1px solid #d1d5db !important;"
                                class="shadow appearance-none border rounded w-full py-2 px-3 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 @error('nombre') border-red-500 @enderror" 
                                placeholder="Ej. Enchiladas Suizas">
                            @error('nombre')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="categoria_id" class="block text-gray-700 text-sm font-bold mb-2">Categoría:</label>
                            <select name="categoria_id" id="categoria_id" 
                                style="color: #000000 !important; background-color: #ffffff !important; border: 1px solid #d1d5db !important; display: block !important; width: 100% !important; padding: 8px !important; border-radius: 4px !important; appearance: auto !important; -webkit-appearance: auto !important;"
                                class="shadow border rounded w-full py-2 px-3 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 @error('categoria_id') border-red-500 @enderror">
                                <option value="" style="color: #000000 !important; background-color: #ffffff !important;">-- Selecciona una categoría --</option>
                                @foreach($categorias as $categoria)
                                    <option value="{{ $categoria->id }}" 
                                            style="color: #000000 !important; background-color: #ffffff !important;"
                                            {{ old('categoria_id') == $categoria->id ? 'selected' : '' }}>
                                        {{ $categoria->categoria }}
                                    </option>
                                @endforeach
                            </select>
                            @error('categoria_id')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="descripcion" class="block text-gray-700 text-sm font-bold mb-2">Descripción o Ingredientes:</label>
                            <textarea name="descripcion" id="descripcion" rows="3" 
                                style="color: #111827 !important; background-color: #ffffff !important; border: 1px solid #d1d5db !important;"
                                class="shadow appearance-none border rounded w-full py-2 px-3 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 @error('descripcion') border-red-500 @enderror" 
                                placeholder="Descripción detallada del platillo...">{{ old('descripcion') }}</textarea>
                            @error('descripcion')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="precio" class="block text-gray-700 text-sm font-bold mb-2">Precio ($):</label>
                            <input type="number" name="precio" id="precio" step="0.01" min="0" value="{{ old('precio') }}" 
                                style="color: #111827 !important; background-color: #ffffff !important; border: 1px solid #d1d5db !important;"
                                class="shadow appearance-none border rounded w-full py-2 px-3 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 @error('precio') border-red-500 @enderror" 
                                placeholder="0.00">
                            @error('precio')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end space-x-4 mt-6">
                            <a href="{{ route('admin.platillos.index') }}" 
                               style="background-color: #6b7280 !important; color: #ffffff !important; display: inline-flex !important;"
                               class="font-bold py-2 px-4 rounded text-sm transition shadow-sm hover:bg-gray-600 items-center justify-center">
                                Cancelar
                            </a>
                            
                            <button type="submit" 
                                    style="background-color: #1d4ed8 !important; color: #ffffff !important; display: inline-flex !important; border: 1px solid #1e40af !important;"
                                    class="font-bold py-2 px-4 rounded text-sm shadow-md transition hover:bg-blue-800 items-center justify-center">
                                Guardar Platillo
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>