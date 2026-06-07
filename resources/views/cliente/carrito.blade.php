<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-1 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <h2 class="text-xl font-bold leading-tight text-gray-900">Carrito</h2>
                <p class="text-sm text-gray-500">Revision final antes de enviar la orden a cocina.</p>
            </div>

            <a href="{{ route('cliente.menu') }}" class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm hover:bg-gray-50">
                Seguir pidiendo
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            @php
                $total = collect($carrito)->sum(fn ($item) => $item['precio'] * $item['cantidad']);
            @endphp

            <div class="overflow-hidden rounded-md border border-gray-200 bg-white shadow-sm">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-bold uppercase text-gray-500">Platillo</th>
                                <th class="px-6 py-3 text-left text-xs font-bold uppercase text-gray-500">Precio unitario</th>
                                <th class="px-6 py-3 text-left text-xs font-bold uppercase text-gray-500">Cantidad</th>
                                <th class="px-6 py-3 text-left text-xs font-bold uppercase text-gray-500">Subtotal</th>
                                <th class="px-6 py-3 text-right text-xs font-bold uppercase text-gray-500">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            @forelse($carrito as $item)
                                @php
                                    $subtotal = $item['precio'] * $item['cantidad'];
                                @endphp
                                <tr>
                                    <td class="px-6 py-4 text-sm font-semibold text-gray-900">{{ $item['nombre'] }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600">${{ number_format($item['precio'], 2) }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $item['cantidad'] }}</td>
                                    <td class="px-6 py-4 text-sm font-bold text-gray-900">${{ number_format($subtotal, 2) }}</td>
                                    <td class="px-6 py-4 text-right text-sm">
                                        <form action="{{ route('cliente.carrito.eliminar', $item['id']) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="font-semibold text-red-600 hover:text-red-800">
                                                Eliminar
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-10 text-center text-sm text-gray-500">
                                        Tu carrito esta vacio.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="flex flex-col gap-4 border-t border-gray-200 bg-gray-50 px-6 py-5 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <span class="text-sm font-semibold uppercase text-gray-500">Total</span>
                        <p class="text-3xl font-black text-gray-950">${{ number_format($total, 2) }}</p>
                    </div>

                    @if(count($carrito) > 0)
                        <form action="{{ route('cliente.ordenes.store') }}" method="POST">
                            @csrf
                            <button type="submit" class="inline-flex items-center justify-center rounded-md bg-emerald-600 px-5 py-3 text-sm font-bold text-white shadow-sm hover:bg-emerald-700">
                                Confirmar orden
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
