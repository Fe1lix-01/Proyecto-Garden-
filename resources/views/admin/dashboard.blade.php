<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Panel de Administración y Control de Cocina') }}
            </h2>
            
        
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            

            <!-- SECCIÓN 2: MONITOR DE COCINA INTEGRADO -->
            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">🍳 Cocina - Pedidos Activos</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @forelse($ordenes as $orden)
                        <div class="bg-white p-6 rounded-lg shadow-md border-l-4 {{ $orden->estado === 'en espera' ? 'border-yellow-500' : 'border-blue-500' }} hover:shadow-lg transition-all border border-gray-100">
                            
                            <div class="flex justify-between items-center mb-4">
                                <span class="text-sm font-bold text-gray-700">Pedido #{{ str_pad($orden->id, 3, '0', STR_PAD_LEFT) }}</span>
                                <span class="text-xs px-2 py-1 rounded font-semibold {{ $orden->estado === 'en espera' ? 'bg-yellow-100 text-yellow-800' : 'bg-blue-100 text-blue-800' }}">
                                    {{ $orden->estado === 'en espera' ? 'Pendiente' : 'En Preparación' }}
                                </span>
                            </div>

                            <div class="mb-5">
                                <button onclick="abrirModal({{ json_encode($orden) }})" class="w-full text-center bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-semibold py-2 rounded border border-gray-300 transition-all">
                                    Ver Productos del Pedido
                                </button>
                            </div>
                            
                            <div class="flex flex-col space-y-2">
                                <form action="{{ route('cocina.marcarLista', $orden->id) }}" method="POST" class="w-full">
                                    @csrf
                                    <button type="submit" class="w-full text-center bg-zinc-800 hover:bg-zinc-900 text-white text-xs font-bold py-2 px-4 rounded shadow uppercase tracking-wider">
                                        {{ $orden->estado === 'en espera' ? 'Empezar a Preparar' : 'Marcar como Listo' }}
                                    </button>
                                </form>

                                @if($orden->estado === 'en espera')
                                    <form action="{{ route('cocina.cancelar', $orden->id) }}" method="POST" class="w-full" onsubmit="return confirm('¿Estás seguro de que deseas cancelar este pedido?');">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="w-full text-center bg-red-600 hover:bg-red-700 text-white text-xs font-bold py-2 px-4 rounded shadow uppercase tracking-wider transition-all">
                                            Cancelar Orden
                                        </button>
                                    </form>
                                @endif
                            </div>

                        </div>
                    @empty
                        <div class="col-span-3 bg-gray-50 p-8 rounded-lg text-center italic text-gray-500 border border-dashed border-gray-300">
                            No hay pedidos en la cocina en este momento.
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>

    <!-- MODAL DE DESGLOSE -->
    <div id="modalDesglose" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full mx-4 overflow-hidden">
            
            <div class="bg-emerald-800 text-white px-6 py-4 flex justify-between items-center">
                <h3 class="text-lg font-bold tracking-wide uppercase" id="modalTitulo">DESGLOSE DETALLADO</h3>
                <button onclick="cerrarModal()" class="text-white hover:text-gray-200 font-bold text-xl">&times;</button>
            </div>

            <div class="p-6">
                <div class="mb-4 bg-gray-50 p-4 rounded border border-gray-200">
                    <h4 class="text-sm font-bold text-gray-700 mb-2 border-b pb-1">Información General</h4>
                    <div class="grid grid-cols-2 gap-4 text-xs text-gray-600">
                        <p><span class="font-bold text-gray-800">Estado de la Orden:</span> <span id="modalEstado" class="capitalize font-semibold text-amber-600"></span></p>
                        <p><span class="font-bold text-gray-800">Total Pagado:</span> $<span id="modalTotal"></span></p>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-xs text-left">
                        <thead class="bg-gray-100 font-bold text-gray-700">
                            <tr>
                                <th class="px-4 py-2">Producto</th>
                                <th class="px-4 py-2 text-center">Cantidad</th>
                                <th class="px-4 py-2 text-right">Precio de Compra</th>
                            </tr>
                        </thead>
                        <tbody id="modalTablaCuerpo" class="divide-y divide-gray-200 text-gray-600">
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="bg-gray-50 px-6 py-3 flex justify-end space-x-3 border-t">
                <button onclick="cerrarModal()" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold px-4 py-2 rounded text-xs">
                    Cerrar Pantalla
                </button>
            </div>
        </div>
    </div>

    <!-- SCRIPTS -->
    <script>
        function abrirModal(orden) {
            document.getElementById('modalDesglose').classList.remove('hidden');

            document.getElementById('modalTitulo').innerText = "PEDIDO #" + String(orden.id).padStart(3, '0');
            document.getElementById('modalEstado').innerText = orden.estado.replace('_', ' ');
            document.getElementById('modalTotal').innerText = parseFloat(orden.total || 0).toFixed(2);

            const tablaCuerpo = document.getElementById('modalTablaCuerpo');
            tablaCuerpo.innerHTML = ''; 

            // Se usa 'detalles_orden' porque Eloquent serializa las relaciones CamelCase a snake_case en JSON
            const productos = orden.detalles_orden;

            if (productos && productos.length > 0) {
                productos.forEach(function(detalle) {
                    const precio = parseFloat(detalle.precio_unitario || 0).toFixed(2);
                    const nombrePlatillo = detalle.platillo ? detalle.platillo.nombre : "Platillo #" + detalle.platillo_id;

                    const fila = "<tr>" +
                        "<td class='px-4 py-2 font-medium text-gray-900 capitalize'>" + nombrePlatillo + "</td>" +
                        "<td class='px-4 py-2 text-center font-bold text-zinc-800'>" + detalle.cantidad + "</td>" +
                        "<td class='px-4 py-2 text-right'>$" + precio + "</td>" +
                    "</tr>";
                    
                    tablaCuerpo.innerHTML += fila;
                });
            } else {
                tablaCuerpo.innerHTML = '<tr><td colspan="3" class="px-4 py-4 text-center italic text-gray-400">Esta orden no tiene productos registrados.</td></tr>';
            }
        }

        function cerrarModal() {
            document.getElementById('modalDesglose').classList.add('hidden');
        }
    </script>
</x-app-layout>