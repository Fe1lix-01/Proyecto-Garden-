<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Orden del Cliente') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4">Resumen de productos</h3>
                    
                    <div class="overflow-x-auto mb-6">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Platillo</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Precio Unitario</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cantidad</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Subtotal</th>
                                    <th class="px-6 py-3"></th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @php 
                                    $carrito = session('carrito', []); 
                                    $total = 0;
                                @endphp

                                @if(count($carrito) > 0)
                                    @foreach($carrito as $id => $item)
                                        @php 
                                            $subtotal = $item['precio'] * $item['cantidad']; 
                                            $total += $subtotal;
                                        @endphp
                                        <tr>
                                            <td class="px-6 py-4 text-sm text-gray-900">{{ $item['nombre'] }}</td>
                                            <td class="px-6 py-4 text-sm text-gray-600">${{ number_format($item['precio'], 2) }}</td>
                                            <td class="px-6 py-4 text-sm text-gray-600">{{ $item['cantidad'] }}</td>
                                            <td class="px-6 py-4 text-sm font-bold text-gray-900">${{ number_format($subtotal, 2) }}</td>
                                            <td class="px-6 py-4 text-sm text-right">
                                                <form action="{{ route('carrito.eliminar', $id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900 font-medium">Eliminar</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500 italic">Tu carrito está vacío.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                    <div class="flex justify-between items-center border-t pt-4">
                        <div class="text-2xl font-bold text-gray-800">
                            Total: ${{ number_format($total, 2) }}
                        </div>
                        
                        @if(count($carrito) > 0)
                            <form id="form-confirmar" action="{{ route('ordenes.store') }}" method="POST">
                                @csrf
                                {{-- Inyectamos los items serializados para que tu OrdenController los procese al guardar --}}
                                <input type="hidden" name="items" value="{{ json_encode($carrito) }}">
                                
                                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded-lg transition shadow">
                                    Confirmar y Pagar
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>