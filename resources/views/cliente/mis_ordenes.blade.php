<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-xl text-gray-800 leading-tight">
                {{ __('Historial de Ordenes') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($ordenes as $orden)
                    <div class="bg-white rounded-xl shadow-sm border-l-8 overflow-hidden flex flex-col justify-between h-full min-h-[220px] transition transform hover:-translate-y-1 hover:shadow-md
                        {{ $orden->estado === 'pendiente' || $orden->estado === 'en espera' ? 'border-l-yellow-400 border-gray-200 border-y border-r' : '' }}
                        {{ $orden->estado === 'en_preparacion' ? 'border-l-blue-500 border-gray-200 border-y border-r' : '' }}
                        {{ $orden->estado === 'lista' || $orden->estado === 'completada' ? 'border-l-green-500 border-gray-200 border-y border-r' : '' }}
                        {{ $orden->estado === 'cancelada' ? 'border-l-red-500 border-gray-200 border-y border-r' : '' }}
                    ">
                        
                        <div class="p-4 bg-gray-50 border-b border-gray-100 flex justify-between items-center">
                            <div>
                                <span class="block text-lg font-extrabold text-gray-800">Orden #{{ str_pad($orden->id, 3, '0', STR_PAD_LEFT) }}</span>
                                <span class="text-[11px] text-gray-400 font-medium">{{ $orden->created_at->format('d/m H:i A') }}</span>
                            </div>
                            <div class="text-right">
                                <span class="text-2xl font-black text-zinc-900">${{ number_format($orden->total, 2) }}</span>
                            </div>
                        </div>

                        <div class="p-4 flex-grow">
                            <div class="mb-3 flex items-center justify-between">
                                <span class="text-xs uppercase font-bold tracking-wider text-gray-400">Estado:</span>
                                <span class="text-xs px-2.5 py-0.5 rounded-full font-black uppercase tracking-wider
                                    {{ $orden->estado === 'pendiente' || $orden->estado === 'en espera' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $orden->estado === 'en_preparacion' ? 'bg-blue-100 text-blue-800' : '' }}
                                    {{ $orden->estado === 'lista' || $orden->estado === 'completada' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $orden->estado === 'cancelada' ? 'bg-red-100 text-red-800' : '' }}
                                bags">
                                    {{ $orden->estado === 'lista' ? 'Listo' : str_replace('_', ' ', $orden->estado) }}
                                </span>
                            </div>

                            <div class="space-y-1 max-h-[100px] overflow-y-auto pr-1">
                                @foreach($orden->detallesOrden as $detalle)
                                    <p class="text-sm font-semibold text-gray-700 flex justify-between">
                                        <span>• {{ $detalle->cantidad }}x {{ $detalle->platillo ? $detalle->platillo->nombre : 'Platillo' }}</span>
                                        <span class="text-gray-400 font-normal text-xs">${{ number_format($detalle->subtotal, 2) }}</span>
                                    </p>
                                @endforeach
                            </div>
                        </div>

                        @if($orden->estado === 'pendiente')
                            <div class="p-3 bg-gray-50 border-t border-gray-100 text-center">
                                <form action="{{ route('cliente.ordenes.cancelar', $orden->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full text-center text-xs font-bold uppercase tracking-wider text-red-600 hover:text-red-800 hover:bg-red-50 py-1.5 rounded-lg transition">
                                        Cancelar Orden
                                    </button>
                                </form>
                            </div>
                        @endif

                    </div>
                @empty
                    <div class="col-span-1 md:col-span-2 lg:col-span-3 text-center py-12 border border-dashed border-gray-200 rounded-xl bg-gray-50 text-gray-500 italic font-medium">
                        Aún no has realizado ninguna orden. ¡Pide algo del menú!
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>