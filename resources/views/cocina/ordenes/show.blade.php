<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <h2 class="text-xl font-bold leading-tight text-gray-900">Detalle de orden #{{ str_pad($orden->id, 3, '0', STR_PAD_LEFT) }}</h2>
                <p class="text-sm text-gray-500">{{ $orden->user?->name ?? 'Cliente eliminado' }} - {{ $orden->created_at->format('d/m/Y H:i') }}</p>
            </div>

            <a href="{{ route('cocina.ordenes.index') }}" class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm hover:bg-gray-50">
                Volver al panel
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
            @php
                $estadoClases = [
                    'pendiente' => 'bg-yellow-100 text-yellow-800',
                    'en_preparacion' => 'bg-blue-100 text-blue-800',
                    'lista' => 'bg-green-100 text-green-800',
                    'cancelada' => 'bg-red-100 text-red-800',
                ];
                $estadoEtiquetas = [
                    'pendiente' => 'Pendiente',
                    'en_preparacion' => 'En preparacion',
                    'lista' => 'Lista',
                    'cancelada' => 'Cancelada',
                ];
            @endphp

            <div class="overflow-hidden rounded-md border border-gray-200 bg-white shadow-sm">
                <div class="flex flex-col gap-4 border-b border-gray-200 bg-gray-50 p-5 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm font-bold uppercase text-gray-500">Estado</p>
                        <span class="mt-1 inline-flex rounded-full px-3 py-1 text-xs font-black uppercase {{ $estadoClases[$orden->estado] ?? 'bg-gray-100 text-gray-700' }}">
                            {{ $estadoEtiquetas[$orden->estado] ?? $orden->estado }}
                        </span>
                    </div>
                    <div class="text-left sm:text-right">
                        <p class="text-sm font-bold uppercase text-gray-500">Total</p>
                        <p class="text-3xl font-black text-gray-950">${{ number_format($orden->total, 2) }}</p>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-white">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-bold uppercase text-gray-500">Platillo</th>
                                <th class="px-6 py-3 text-left text-xs font-bold uppercase text-gray-500">Cantidad</th>
                                <th class="px-6 py-3 text-left text-xs font-bold uppercase text-gray-500">Precio unitario</th>
                                <th class="px-6 py-3 text-left text-xs font-bold uppercase text-gray-500">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            @foreach($orden->detalles as $detalle)
                                <tr>
                                    <td class="px-6 py-4 text-sm font-semibold text-gray-900">{{ $detalle->platillo?->nombre ?? 'Platillo eliminado' }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $detalle->cantidad }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600">${{ number_format($detalle->precio_unitario, 2) }}</td>
                                    <td class="px-6 py-4 text-sm font-bold text-gray-900">${{ number_format($detalle->subtotal, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="flex flex-col gap-3 border-t border-gray-200 bg-gray-50 p-5 sm:flex-row sm:justify-end">
                    @if($orden->puedeAvanzar())
                        <form action="{{ route('cocina.ordenes.avanzar', $orden) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="w-full rounded-md bg-gray-900 px-4 py-2 text-sm font-bold text-white hover:bg-gray-800 sm:w-auto">
                                {{ $orden->estado === 'pendiente' ? 'Pasar a preparacion' : 'Marcar lista' }}
                            </button>
                        </form>
                    @endif

                    @if($orden->puedeCancelarse())
                        <form action="{{ route('cocina.ordenes.cancelar', $orden) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="w-full rounded-md border border-red-200 bg-white px-4 py-2 text-sm font-bold text-red-600 hover:bg-red-50 sm:w-auto">
                                Cancelar orden
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
