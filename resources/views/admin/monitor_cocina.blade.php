<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-xl text-gray-800 leading-tight">
                {{ __('Ordenes Activas') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($ordenes as $orden)
                    <div
                        class="bg-white rounded-xl shadow-sm border-l-8 overflow-hidden flex flex-col justify-between h-full min-h-[240px] transition transform hover:-translate-y-1 hover:shadow-md
                        {{ $orden->estado === 'pendiente' ? 'border-l-yellow-400 border-gray-200 border-y border-r' : '' }}
                        {{ $orden->estado === 'en_preparacion' ? 'border-l-blue-500 border-gray-200 border-y border-r' : '' }}
                    ">

                        <div class="p-4 bg-gray-50 border-b border-gray-100 flex justify-between items-center">
                            <div>
                                <span class="block text-lg font-extrabold text-gray-800">Pedido
                                    #{{ str_pad($orden->id, 3, '0', STR_PAD_LEFT) }}</span>
                                <span class="text-[11px] text-gray-400 font-medium">Recibido:
                                    {{ $orden->created_at->format('H:i A') }}</span>
                            </div>
                            <div class="text-right">
                                <span
                                    class="text-2xl font-black text-zinc-900">${{ number_format($orden->total, 2) }}</span>
                            </div>
                        </div>

                        <div class="p-4 flex-grow flex flex-col justify-between">
                            <div class="mb-3 flex items-center justify-between">
                                <span class="text-xs uppercase font-bold tracking-wider text-gray-400">Estado
                                    actual:</span>
                                <span
                                    class="text-xs px-2.5 py-0.5 rounded-full font-black uppercase tracking-wider
                                    {{ $orden->estado === 'pendiente' ? 'bg-yellow-100 text-yellow-800' : 'bg-blue-100 text-blue-800' }}
                                ">
                                    {{ $orden->estado === 'pendiente' ? 'Pendiente' : 'En Preparación' }}
                                </span>
                            </div>

                            <div class="space-y-1 max-h-[100px] overflow-y-auto pr-1">
                                @if ($orden->detallesOrden && $orden->detallesOrden->count() > 0)
                                    @foreach ($orden->detallesOrden as $detalle)
                                        <p class="text-sm font-semibold text-gray-700 flex justify-between">
                                            <span>• {{ $detalle->cantidad }}x
                                                {{ $detalle->platillo ? $detalle->platillo->nombre : 'Platillo #' . $detalle->platillo_id }}</span>
                                        </p>
                                    @endforeach
                                @else
                                    <p class="text-xs text-gray-400 italic">Esta orden no tiene productos registrados.
                                    </p>
                                @endif
                            </div>
                        </div>

                        <div class="p-3 bg-gray-50 border-t border-gray-100 flex flex-col space-y-2">
                            <form action="{{ route('cocina.marcarLista', $orden->id) }}" method="POST" class="w-full">
                                @csrf
                                <button type="submit"
                                    class="w-full text-center bg-zinc-800 hover:bg-zinc-900 text-white text-xs font-bold py-2 px-4 rounded-lg shadow uppercase tracking-wider transition">
                                    {{ $orden->estado === 'pendiente' ? 'Empezar a Preparar' : 'Marcar como Listo' }}
                                </button>
                            </form>

                            @if ($orden->estado === 'pendiente')
                                <form action="{{ route('cocina.cancelar', $orden->id) }}" method="POST"
                                    class="w-full">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit"
                                        class="w-full text-center text-xs font-bold uppercase tracking-wider text-red-600 hover:text-red-800 hover:bg-red-50 py-1.5 rounded-lg transition">
                                        Cancelar Orden
                                    </button>
                                </form>
                            @endif
                        </div>

                    </div>
                @empty
                    <div
                        class="col-span-1 md:col-span-2 lg:col-span-3 bg-white p-8 rounded-xl text-center italic text-gray-500 border border-dashed border-gray-300 font-medium">
                        No hay pedidos en la cocina en este momento.
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <script>
        // Ejecuta una función repetitiva cada 10,000 milisegundos (10 segundos)
        setInterval(function() {
            // Hacemos una petición silenciosa al monitor de cocina
            fetch('{{ route('admin.monitor_cocina') }}')
                .then(response => response.text())
                .then(html => {
                    // Parseamos el HTML recibido para extraer solo el contenedor de las órdenes
                    fontDOM = new DOMParser().parseFromString(html, 'text/html');
                    const nuevoContenedor = fontDOM.querySelector('.grid');

                    // Reemplazamos el contenedor viejo por el nuevo con los datos frescos
                    if (nuevoContenedor) {
                        document.querySelector('.grid').innerHTML = nuevoContenedor.innerHTML;
                    }
                })
                .catch(error => console.warn("Error al actualizar pedidos:", error));
        }, 10000);
    </script>
</x-app-layout>
