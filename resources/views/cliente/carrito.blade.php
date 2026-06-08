<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="mb-2 text-xs font-black uppercase tracking-[0.25em] text-[#b02f00]">Checkout</p>
                <h2 class="gf-title">Carrito</h2>
                <p class="gf-subtitle mt-2">Revision final antes de enviar la orden.</p>
            </div>

            <a href="{{ route('cliente.menu') }}" class="gf-button-outline">
                Seguir pidiendo
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            @php
                $total = collect($carrito)->sum(fn ($item) => $item['precio'] * $item['cantidad']);
            @endphp

            <div class="grid grid-cols-1 gap-6 lg:grid-cols-[1fr_360px]">
                <section class="gf-card">
                    <div class="gf-dark-head px-6 py-4">
                        <h3 class="font-display text-xl font-black">Productos seleccionados</h3>
                    </div>
                    <div class="divide-y divide-[#e4e2e0]">
                        @forelse($carrito as $item)
                            @php
                                $subtotal = $item['precio'] * $item['cantidad'];
                                $itemImagen = ! empty($item['imagen']) ? asset('uploads/'.$item['imagen']) : asset('img/garden.jpeg');
                            @endphp
                            <div class="grid grid-cols-1 gap-4 p-5 sm:grid-cols-[1fr_auto] sm:items-center">
                                <div class="flex items-center gap-4">
                                    <img src="{{ $itemImagen }}" alt="Imagen de {{ $item['nombre'] }}" class="h-16 w-16 shrink-0 rounded-xl object-cover">
                                    <div>
                                        <p class="font-display text-xl font-black text-[#1b1c1b]">{{ $item['nombre'] }}</p>
                                        <p class="mt-1 text-sm text-[#5b4039]">${{ number_format($item['precio'], 2) }} por unidad · {{ $item['cantidad'] }} pieza(s)</p>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between gap-5 sm:justify-end">
                                    <p class="font-display text-2xl font-black text-[#b02f00]">${{ number_format($subtotal, 2) }}</p>
                                    <form action="{{ route('cliente.carrito.eliminar', $item['id']) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="gf-button-danger">
                                            Eliminar
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <div class="p-10 text-center text-[#5b4039]">
                                Tu carrito esta vacio.
                            </div>
                        @endforelse
                    </div>
                </section>

                <aside class="gf-card h-fit p-6">
                    <p class="text-xs font-black uppercase tracking-[0.25em] text-[#b02f00]">Resumen</p>
                    <div class="mt-5 space-y-4">
                        <div class="flex justify-between text-sm text-[#5b4039]">
                            <span>Productos</span>
                            <span>{{ collect($carrito)->sum('cantidad') }}</span>
                        </div>
                        <div class="flex justify-between border-t border-[#e4beb4] pt-4">
                            <span class="font-display text-2xl font-black">Total</span>
                            <span class="font-display text-3xl font-black text-[#b02f00]">${{ number_format($total, 2) }}</span>
                        </div>
                    </div>

                    @if(count($carrito) > 0)
                        <form action="{{ route('cliente.ordenes.store') }}" method="POST" class="mt-6">
                            @csrf
                            <button type="submit" class="gf-button-primary w-full">
                                Confirmar orden
                            </button>
                        </form>
                    @endif
                </aside>
            </div>
        </div>
    </div>
</x-app-layout>
