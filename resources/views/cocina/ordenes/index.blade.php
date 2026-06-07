<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <h2 class="text-xl font-bold leading-tight text-gray-900">Panel de cocina</h2>
                <p class="text-sm text-gray-500">Ordenes ordenadas por llegada.</p>
            </div>

            <a href="{{ route('cocina.platillos.index') }}" class="inline-flex items-center justify-center rounded-md bg-gray-900 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-gray-800">
                Gestionar platillos
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
                $filtros = [
                    'activas' => 'Activas',
                    'pendiente' => 'Pendientes',
                    'en_preparacion' => 'En preparacion',
                    'lista' => 'Listas',
                    'cancelada' => 'Canceladas',
                    'todas' => 'Todas',
                ];
            @endphp

            <div id="ordenes-panel">
                <div class="mb-5 grid grid-cols-1 gap-4 md:grid-cols-[1fr_auto] md:items-center">
                    <div class="flex flex-wrap gap-2">
                        @foreach($filtros as $valor => $texto)
                            <a href="{{ route('cocina.ordenes.index', ['estado' => $valor]) }}"
                                class="rounded-full px-3 py-2 text-sm font-bold transition
                                {{ $filtro === $valor ? 'bg-indigo-600 text-white shadow-sm' : 'bg-white text-gray-700 ring-1 ring-gray-200 hover:bg-gray-50' }}">
                                {{ $texto }}
                            </a>
                        @endforeach
                    </div>

                    <div class="rounded-md border border-yellow-200 bg-yellow-50 px-4 py-3 text-sm font-bold text-yellow-800">
                        Pendientes: <span id="contador-pendientes">{{ $conteos['pendiente'] }}</span>
                    </div>
                </div>

                <div id="ordenes-grid" class="grid grid-cols-1 gap-5 lg:grid-cols-2 xl:grid-cols-3">
                    @forelse($ordenes as $orden)
                        @php
                            $clases = $estadoClases[$orden->estado] ?? 'border-gray-300 bg-gray-100 text-gray-700';
                            $borderClass = explode(' ', $clases)[0];
                            $badgeClass = implode(' ', array_slice(explode(' ', $clases), 1));
                        @endphp

                        <article class="flex min-h-[330px] flex-col justify-between rounded-md border border-l-8 bg-white shadow-sm {{ $borderClass }}">
                            <div class="border-b border-gray-100 bg-gray-50 p-4">
                                <div class="flex items-start justify-between gap-4">
                                    <div>
                                        <h3 class="text-lg font-extrabold text-gray-900">Orden #{{ str_pad($orden->id, 3, '0', STR_PAD_LEFT) }}</h3>
                                        <p class="text-xs font-medium text-gray-500">{{ $orden->created_at->format('d/m/Y H:i') }}</p>
                                        <p class="mt-1 text-sm font-semibold text-gray-700">{{ $orden->user?->name ?? 'Cliente eliminado' }}</p>
                                    </div>
                                    <p class="text-2xl font-black text-gray-950">${{ number_format($orden->total, 2) }}</p>
                                </div>

                                <span class="mt-3 inline-flex rounded-full px-2.5 py-1 text-xs font-black uppercase {{ $badgeClass }}">
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

                            <div class="space-y-2 border-t border-gray-100 bg-gray-50 p-3">
                                <a href="{{ route('cocina.ordenes.show', $orden) }}" class="block rounded-md border border-gray-300 bg-white px-3 py-2 text-center text-xs font-bold uppercase text-gray-700 hover:bg-gray-50">
                                    Ver detalle
                                </a>

                                @if($orden->puedeAvanzar())
                                    <form action="{{ route('cocina.ordenes.avanzar', $orden) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="w-full rounded-md bg-gray-900 px-3 py-2 text-xs font-bold uppercase text-white hover:bg-gray-800">
                                            {{ $orden->estado === 'pendiente' ? 'Pasar a preparacion' : 'Marcar lista' }}
                                        </button>
                                    </form>
                                @endif

                                @if($orden->puedeCancelarse())
                                    <form action="{{ route('cocina.ordenes.cancelar', $orden) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="w-full rounded-md px-3 py-2 text-xs font-bold uppercase text-red-600 hover:bg-red-50 hover:text-red-800">
                                            Cancelar orden
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </article>
                    @empty
                        <div class="rounded-md border border-dashed border-gray-300 bg-white p-10 text-center text-gray-500 lg:col-span-2 xl:col-span-3">
                            No hay ordenes para este filtro.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <script>
        setInterval(async () => {
            try {
                const response = await fetch(window.location.href, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' },
                });
                const html = await response.text();
                const doc = new DOMParser().parseFromString(html, 'text/html');
                const nuevoPanel = doc.querySelector('#ordenes-panel');
                const panelActual = document.querySelector('#ordenes-panel');

                if (nuevoPanel && panelActual) {
                    panelActual.innerHTML = nuevoPanel.innerHTML;
                }
            } catch (error) {
                console.warn('No se pudo actualizar el panel de cocina.', error);
            }
        }, 10000);
    </script>
</x-app-layout>
