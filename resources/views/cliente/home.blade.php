<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ ('Menú del Restaurante') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-col md:flex-row gap-6">
            
            <div class="w-full md:w-2/3 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 border-b border-gray-200">
                    <h3 class="text-2xl font-bold mb-6">¿Qué se te antoja pedir hoy?</h3>
                    
                    @foreach($categorias as $categoria)
                        
                        @if($categoria->platillos->count() > 0)
                            <div class="mb-8">
                                <h4 class="text-xl font-bold text-gray-800 border-b-2 border-indigo-500 pb-2 mb-4 inline-block">
                                    {{ $categoria->categoria }}
                                </h4>
                                
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    @foreach($categoria->platillos as $platillo)
                                        <div class="border border-gray-300 p-4 rounded-lg shadow-sm hover:shadow-md transition">
                                            <h5 class="text-lg font-semibold">{{ $platillo->nombre }}</h5>
                                            <p class="text-gray-600 text-sm mt-1 h-10">{{ $platillo->descripcion }}</p>
                                            <p class="text-lg font-bold mt-2 text-indigo-600">${{ number_format($platillo->precio, 2) }}</p>
                                            
                                            <form action="/carrito/agregar" method="POST" class="mt-4 flex items-center">
                                                @csrf
                                                <input type="hidden" name="platillo_id" value="{{ $platillo->id }}">
                                                <label for="cantidad_{{ $platillo->id }}" class="mr-2 text-sm font-medium text-gray-700">Cant:</label>
                                                <input type="number" id="cantidad_{{ $platillo->id }}" name="cantidad" value="1" min="1" class="w-16 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm mr-3 text-center">
                                                <button type="submit" class="bg-gray-800 text-white px-3 py-1.5 rounded-md hover:bg-gray-700 transition font-semibold text-sm">
                                                    Agregar
                                                </button>
                                            </form>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        
                    @endforeach

                </div>
            </div>

            <div class="w-full md:w-1/3">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg sticky top-6">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-bold mb-4 flex items-center border-b pb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            Tu Orden
                        </h3>
                        
                        <ul class="mb-4 border-b border-gray-200 pb-4 space-y-3 mt-4">
                            <li class="flex justify-between items-center text-sm">
                                <span class="text-gray-500 italic">El carrito está vacío...</span>
                            </li>
                        </ul>
                        
                        <div class="flex justify-between font-bold text-xl mb-6 text-gray-900">
                            <span>Total:</span>
                            <span>$0.00</span>
                        </div>
                        
                        <form action="/ordenes" method="POST">
                            @csrf
                            <button type="button" class="w-full bg-green-600 text-white py-3 rounded-md hover:bg-green-700 transition font-bold text-center shadow-md opacity-50 cursor-not-allowed">
                                Confirmar Orden
                            </button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>