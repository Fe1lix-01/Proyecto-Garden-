<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-1 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <h2 class="text-xl font-bold leading-tight text-gray-900">Mis ordenes</h2>
                <p class="text-sm text-gray-500">Historial y estado de tus pedidos.</p>
            </div>

            <a href="{{ route('cliente.menu') }}" class="inline-flex items-center justify-center rounded-md bg-gray-900 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-gray-800">
                Nuevo pedido
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            @php
                $estadoClases = [
                    'pendiente' => 'border-yellow-400 bg-yellow-100 text-yellow-800',
                    'en_preparacion' => 'border-blue-500 bg-blue-100 text-blue-800',
                    'lista' => 'border-green-500 bg-green-100 text-green-800',
                    'cancelada' => 'border-red-500 bg-red-100 text-red-800',
                ];
                $estadoEtiquetas = [
                    'pendiente' => 'Pendiente',
                    'en_preparacion' => 'En preparacion',
                    'lista' => 'Lista',
                    'cancelada' => 'Cancelada',
                ];
            @endphp

            <div class="grid grid-cols-1 gap-5 md:grid-cols-2 xl:grid-cols-3">
                @forelse($ordenes as $orden)
                    @php
                        $clases = $estadoClases[$orden->estado] ?? 'border-gray-300 bg-gray-100 text-gray-700';
                    @endphp
                    <article class="flex min-h-[260px] flex-col justify-between rounded-md border border-l-8 bg-white shadow-sm {{ explode(' ', $clases)[0] }}">
                        <div class="border-b border-gray-100 bg-gray-50 p-4">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <h3 class="text-lg font-extrabold text-gray-900">Orden #{{ str_pad($orden->id, 3, '0', STR_PAD_LEFT) }}</h3>
                                    <p class="text-xs font-medium text-gray-500">{{ $orden->created_at->format('d/m/Y H:i') }}</p>
                                </div>
                                <p class="text-2xl font-black text-gray-950">${{ number_format($orden->total, 2) }}</p>
                            </div>

                            <span class="mt-3 inline-flex rounded-full px-2.5 py-1 text-xs font-black uppercase {{ implode(' ', array_slice(explode(' ', $clases), 1)) }}">
                                {{ $estadoEtiquetas[$orden->estado] ?? $orden->estado }}
                            </span>
                        </div>

                        <div class="space-y-2 p-4">
                            @foreach($orden->detalles as $detalle)
                                <div class="flex justify-between gap-4 text-sm">
                                    <span class="font-semibold text-gray-700">{{ $detalle->cantidad }}x {{ $detalle->platillo?->nombre ?? 'Platillo eliminado' }}</span>
                                    <span class="font-bold text-gray-900">${{ number_format($detalle->subtotal, 2) }}</span>
                                </div>
                            @endforeach
                        </div>

                        @if($orden->estado === 'pendiente')
                            <div class="border-t border-gray-100 bg-gray-50 p-3">
                                <form action="{{ route('cliente.ordenes.cancelar', $orden) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="w-full rounded-md px-3 py-2 text-center text-xs font-bold uppercase text-red-600 hover:bg-red-50 hover:text-red-800">
                                        Cancelar orden
                                    </button>
                                </form>
                            </div>
                        @endif
                    </article>
                @empty
                    <div class="rounded-md border border-dashed border-gray-300 bg-white p-10 text-center text-gray-500 md:col-span-2 xl:col-span-3">
                        Aun no has realizado ordenes.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
