<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ 'Menú del Restaurante' }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm">
                    <p class="font-bold">¡Listo!</p>
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-bold mb-6 border-b pb-4">¿Qué se te antoja pedir hoy?</h3>
                    
                    @if(isset($categorias) && $categorias->count() > 0)
                        @foreach($categorias as $categoria)
                            @if($categoria->platillos->count() > 0)
                                <div class="mb-10">
                                    <h4 class="text-xl font-black text-gray-800 uppercase tracking-wider mb-4 text-indigo-600">
                                        {{ $categoria->categoria }}
                                    </h4>
                                    
                                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                                        @foreach($categoria->platillos as $platillo)
                                            <div class="border border-gray-200 p-5 rounded-xl shadow-sm hover:shadow-md transition bg-gray-50 flex flex-col justify-between">
                                                <div>
                                                    <h5 class="text-lg font-bold text-gray-900">{{ $platillo->nombre }}</h5>
                                                    <p class="text-gray-600 text-sm mt-1 h-12 overflow-hidden">{{ $platillo->descripcion }}</p>
                                                    <p class="text-xl font-black mt-2 text-gray-800">${{ number_format($platillo->precio, 2) }}</p>
                                                </div>
                                                
                                                <form action="/carrito/agregar" method="POST" class="mt-4 flex items-center justify-between border-t border-gray-300 pt-4">
                                                    @csrf
                                                    <input type="hidden" name="platillo_id" value="{{ $platillo->id }}">
                                                    <div class="flex items-center">
                                                        <label for="cantidad_{{ $platillo->id }}" class="mr-2 text-sm font-bold text-gray-700">Cant:</label>
                                                        <input type="number" id="cantidad_{{ $platillo->id }}" name="cantidad" value="1" min="1" class="w-16 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm text-center">
                                                    </div>
                                                    <button type="submit" class="bg-gray-800 text-white px-3 py-2 rounded-md hover:bg-gray-700 transition font-bold text-sm">
                                                        Agregar
                                                    </button>
                                                </form>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @else
                        <p class="text-gray-500 italic">No hay platillos disponibles en este momento.</p>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>