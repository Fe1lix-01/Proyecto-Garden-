<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="mb-2 text-xs font-black uppercase tracking-[0.25em] text-[#b02f00]">Detalle de orden</p>
                <h2 class="gf-title">Orden #{{ str_pad($orden->id, 4, '0', STR_PAD_LEFT) }}</h2>
                <p class="gf-subtitle mt-2">{{ $orden->user?->name ?? 'Cliente eliminado' }} - {{ $orden->created_at->format('d/m/Y H:i') }}</p>
            </div>

            <a href="{{ route('cocina.ordenes.index') }}" class="gf-button-outline">
                Volver al panel
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
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

            <div class="gf-card">
                <div class="gf-dark-head flex flex-col gap-4 p-6 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <p class="text-xs font-black uppercase tracking-wide text-white/70">Estado</p>
                        <span class="mt-2 inline-flex rounded-full px-3 py-1 text-xs font-black uppercase {{ $estadoClases[$orden->estado] ?? 'bg-gray-100 text-gray-700' }}">
                            {{ $estadoEtiquetas[$orden->estado] ?? $orden->estado }}
                        </span>
                    </div>
                    <div class="sm:text-right">
                        <p class="text-xs font-black uppercase tracking-wide text-white/70">Total</p>
                        <p class="font-display text-4xl font-black text-[#ffb5a0]">${{ number_format($orden->total, 2) }}</p>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="gf-table">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Precio unitario</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                            @foreach($orden->detalles as $detalle)
                                <tr>
                                    @php
                                        $detalleImagen = $detalle->platillo?->imagen ? asset('uploads/'.$detalle->platillo->imagen) : asset('img/garden.jpeg');
                                    @endphp
                                    <td>
                                        <div class="flex items-center gap-3">
                                            <img src="{{ $detalleImagen }}" alt="Imagen de {{ $detalle->platillo?->nombre ?? 'Producto eliminado' }}" class="h-11 w-11 shrink-0 rounded-lg object-cover">
                                            <span class="font-bold text-[#1b1c1b]">{{ $detalle->platillo?->nombre ?? 'Producto eliminado' }}</span>
                                        </div>
                                    </td>
                                    <td class="text-[#5b4039]">{{ $detalle->cantidad }}</td>
                                    <td class="text-[#5b4039]">${{ number_format($detalle->precio_unitario, 2) }}</td>
                                    <td class="font-black text-[#b02f00]">${{ number_format($detalle->subtotal, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="flex flex-col gap-3 border-t border-[#e4e2e0] bg-[#f5f3f1] p-5 sm:flex-row sm:justify-end">
                    @if($orden->puedeAvanzar())
                        <form action="{{ route('cocina.ordenes.avanzar', $orden) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="gf-button-primary w-full sm:w-auto">
                                {{ $orden->estado === 'pendiente' ? 'Pasar a preparacion' : 'Marcar lista' }}
                            </button>
                        </form>
                    @endif

                    @if($orden->puedeCancelarse())
                        <form action="{{ route('cocina.ordenes.cancelar', $orden) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="gf-button-danger w-full sm:w-auto">
                                Cancelar orden
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
