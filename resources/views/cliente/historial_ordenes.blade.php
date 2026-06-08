<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="mb-2 text-xs font-black uppercase tracking-[0.25em] text-[#b02f00]">Order history</p>
                <h2 class="gf-title">Mis ordenes</h2>
                <p class="gf-subtitle mt-2">Historial y estado de tus pedidos recientes.</p>
            </div>

            <a href="{{ route('cliente.menu') }}" class="gf-button-primary">
                Nuevo pedido
            </a>
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
            @endphp

            <div class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-3">
                @forelse($ordenes as $orden)
                    <article class="gf-card flex min-h-[320px] flex-col">
                        <div class="gf-dark-head flex items-center justify-between px-5 py-4">
                            <div>
                                <p class="text-xs font-bold uppercase tracking-wide text-white/70">Orden</p>
                                <h3 class="font-display text-2xl font-black">#{{ str_pad($orden->id, 4, '0', STR_PAD_LEFT) }}</h3>
                            </div>
                            <span class="rounded-full px-3 py-1 text-xs font-black uppercase {{ $estadoClases[$orden->estado] ?? 'bg-gray-100 text-gray-700' }}">
                                {{ $estadoEtiquetas[$orden->estado] ?? $orden->estado }}
                            </span>
                        </div>

                        <div class="flex-1 p-5">
                            <p class="mb-4 text-sm font-semibold text-[#5b4039]">{{ $orden->created_at->format('d/m/Y H:i') }}</p>
                            <div class="space-y-3">
                                @foreach($orden->detalles as $detalle)
                                    @php
                                        $detalleImagen = $detalle->platillo?->imagen ? asset('uploads/'.$detalle->platillo->imagen) : asset('img/garden.jpeg');
                                    @endphp
                                    <div class="flex items-center justify-between gap-4 border-b border-[#e4e2e0] pb-3 text-sm">
                                        <div class="flex items-center gap-3">
                                            <img src="{{ $detalleImagen }}" alt="Imagen de {{ $detalle->platillo?->nombre ?? 'Producto eliminado' }}" class="h-11 w-11 shrink-0 rounded-lg object-cover">
                                            <span class="font-semibold text-[#1b1c1b]">{{ $detalle->cantidad }}x {{ $detalle->platillo?->nombre ?? 'Producto eliminado' }}</span>
                                        </div>
                                        <span class="font-bold text-[#5b4039]">${{ number_format($detalle->subtotal, 2) }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="border-t border-[#e4e2e0] bg-[#f5f3f1] p-5">
                            <div class="mb-4 flex items-center justify-between">
                                <span class="font-display text-xl font-black">Total</span>
                                <span class="font-display text-2xl font-black text-[#b02f00]">${{ number_format($orden->total, 2) }}</span>
                            </div>

                            @if($orden->estado === 'pendiente')
                                <form action="{{ route('cliente.ordenes.cancelar', $orden) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="gf-button-danger w-full">
                                        Cancelar orden
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('cliente.menu') }}" class="gf-button-secondary w-full">
                                    Ordenar de nuevo
                                </a>
                            @endif
                        </div>
                    </article>
                @empty
                    <div class="gf-panel p-10 text-center text-[#5b4039] md:col-span-2 xl:col-span-3">
                        Aun no has realizado ordenes.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
