<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-5 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <p class="mb-2 text-xs font-black uppercase tracking-[0.25em] text-[#b02f00]">Auto-refresh cada 10s</p>
                <h2 class="gf-title">Kitchen Status</h2>
                <p class="gf-subtitle mt-2">Flujo FIFO de ordenes para barra y cocina.</p>
            </div>

            <div class="rounded-2xl bg-[#b02f00] px-6 py-5 text-white shadow-xl">
                <p class="text-xs font-black uppercase tracking-[0.25em] text-white/75">Pendientes</p>
                <p class="font-display text-5xl font-black leading-none" id="contador-pendientes">{{ $conteos['pendiente'] }}</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            @php
                $estadoClases = [
                    'pendiente' => 'gf-status-pendiente',
                    'en_preparacion' => 'gf-status-preparacion',
                    'lista' => 'gf-status-lista',
                    'cancelada' => 'gf-status-cancelada',
                ];
                $estadoEtiquetas = [
                    'pendiente' => 'Pendiente',
                    'en_preparacion' => 'En preparacion',
                    'lista' => 'Lista',
                    'cancelada' => 'Cancelada',
                ];
                $filtros = [
                    'activas' => ['Activas', $conteos['pendiente'] + $conteos['en_preparacion']],
                    'pendiente' => ['Pendiente', $conteos['pendiente']],
                    'en_preparacion' => ['En preparacion', $conteos['en_preparacion']],
                    'lista' => ['Lista', $conteos['lista']],
                    'cancelada' => ['Cancelada', $conteos['cancelada']],
                    'todas' => ['Todas', array_sum($conteos)],
                ];
            @endphp

            <div id="ordenes-panel" class="grid grid-cols-1 gap-6 xl:grid-cols-[320px_1fr]">
                <aside class="space-y-5">
                    <div class="gf-panel p-5">
                        <p class="mb-4 text-sm font-black uppercase tracking-wide text-[#5b4039]">Filtrar por estado</p>
                        <div class="space-y-3">
                            @foreach($filtros as $valor => [$texto, $contador])
                                <a href="{{ route('cocina.ordenes.index', ['estado' => $valor]) }}"
                                   class="flex items-center justify-between rounded-xl px-4 py-3 text-sm font-black transition
                                   {{ $filtro === $valor ? 'border-2 border-[#b02f00] bg-[#ffdbd1] text-[#541200]' : 'bg-[#efedec] text-[#5b4039] hover:bg-[#e4e2e0]' }}">
                                    <span>{{ $texto }}</span>
                                    <span>{{ $contador }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <div class="rounded-2xl border border-[#e4beb4] bg-[#d7e4ec] p-5 text-[#3c494f]">
                        <p class="text-xs font-black uppercase tracking-wide">Orden FIFO</p>
                        <p class="mt-2 font-display text-3xl font-black">{{ $ordenes->count() }} activas</p>
                        <div class="mt-4 h-2 overflow-hidden rounded-full bg-white">
                            <div class="h-full w-3/4 rounded-full bg-[#b02f00]"></div>
                        </div>
                    </div>
                </aside>

                <section id="ordenes-grid" class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                    @forelse($ordenes as $orden)
                        <article class="gf-card flex min-h-[390px] flex-col">
                            <div class="gf-dark-head flex items-start justify-between gap-4 px-5 py-4">
                                <div>
                                    <p class="text-xs font-bold uppercase tracking-wide text-white/65">Orden</p>
                                    <h3 class="font-display text-3xl font-black">#{{ str_pad($orden->id, 4, '0', STR_PAD_LEFT) }}</h3>
                                    <p class="mt-1 text-sm text-white/75">{{ $orden->user?->name ?? 'Cliente eliminado' }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-xs font-bold text-[#ffb5a0]">{{ $orden->created_at->format('H:i') }}</p>
                                    <span class="mt-2 inline-flex rounded-full px-3 py-1 text-xs font-black uppercase {{ $estadoClases[$orden->estado] ?? 'bg-gray-100 text-gray-700' }}">
                                        {{ $estadoEtiquetas[$orden->estado] ?? $orden->estado }}
                                    </span>
                                </div>
                            </div>

                            <div class="flex-1 p-5">
                                <ul class="space-y-4">
                                    @foreach($orden->detalles as $detalle)
                                        <li class="flex gap-4 border-b border-[#e4e2e0] pb-4">
                                            <span class="font-display text-xl font-black text-[#b02f00]">{{ $detalle->cantidad }}x</span>
                                            <div class="flex-1">
                                                <p class="font-bold text-[#1b1c1b]">{{ $detalle->platillo?->nombre ?? 'Producto eliminado' }}</p>
                                                <p class="mt-1 text-sm text-[#5b4039]">${{ number_format($detalle->subtotal, 2) }}</p>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>

                            <div class="space-y-3 border-t border-[#e4e2e0] bg-[#f5f3f1] p-4">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm font-black uppercase text-[#5b4039]">Total</span>
                                    <span class="font-display text-2xl font-black text-[#b02f00]">${{ number_format($orden->total, 2) }}</span>
                                </div>

                                <div class="grid grid-cols-1 gap-2 sm:grid-cols-3">
                                    <a href="{{ route('cocina.ordenes.show', $orden) }}" class="gf-button-outline px-3 py-2">
                                        Detalle
                                    </a>

                                    @if($orden->puedeAvanzar())
                                        <form action="{{ route('cocina.ordenes.avanzar', $orden) }}" method="POST" class="sm:col-span-1">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="gf-button-primary w-full px-3 py-2">
                                                {{ $orden->estado === 'pendiente' ? 'Preparamos' : 'Lista' }}
                                            </button>
                                        </form>
                                    @endif

                                    @if($orden->puedeCancelarse())
                                        <form action="{{ route('cocina.ordenes.cancelar', $orden) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="gf-button-danger w-full px-3 py-2">
                                                Cancelar
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </article>
                    @empty
                        <div class="gf-panel p-10 text-center text-[#5b4039] lg:col-span-2">
                            No hay ordenes para este filtro.
                        </div>
                    @endforelse
                </section>
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
