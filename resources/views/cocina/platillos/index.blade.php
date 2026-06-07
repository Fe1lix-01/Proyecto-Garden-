<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <h2 class="text-xl font-bold leading-tight text-gray-900">Productos de la carta</h2>
                <p class="text-sm text-gray-500">Bebidas, promociones, botellas, comida y extras.</p>
            </div>

            <a href="{{ route('cocina.platillos.create') }}" class="inline-flex items-center justify-center rounded-md bg-emerald-700 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-emerald-800">
                Nuevo producto
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="overflow-hidden rounded-md border border-gray-200 bg-white shadow-sm">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-bold uppercase text-gray-500">Nombre</th>
                                <th class="px-6 py-3 text-left text-xs font-bold uppercase text-gray-500">Categoria</th>
                                <th class="px-6 py-3 text-left text-xs font-bold uppercase text-gray-500">Descripcion</th>
                                <th class="px-6 py-3 text-left text-xs font-bold uppercase text-gray-500">Precio</th>
                                <th class="px-6 py-3 text-center text-xs font-bold uppercase text-gray-500">Disponibilidad</th>
                                <th class="px-6 py-3 text-right text-xs font-bold uppercase text-gray-500">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            @forelse($platillos as $platillo)
                                <tr>
                                    <td class="px-6 py-4 text-sm font-semibold text-gray-900">{{ $platillo->nombre }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $platillo->categoria?->categoria ?? 'Sin categoria' }}</td>
                                    <td class="max-w-xs truncate px-6 py-4 text-sm text-gray-600">{{ $platillo->descripcion }}</td>
                                    <td class="px-6 py-4 text-sm font-bold text-gray-900">${{ number_format($platillo->precio, 2) }}</td>
                                    <td class="px-6 py-4 text-center">
                                        <form action="{{ route('cocina.platillos.disponibilidad', $platillo) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="rounded-full px-3 py-1 text-xs font-black uppercase {{ $platillo->disponible ? 'bg-green-100 text-green-800 hover:bg-green-200' : 'bg-red-100 text-red-800 hover:bg-red-200' }}">
                                                {{ $platillo->disponible ? 'Disponible' : 'Agotado' }}
                                            </button>
                                        </form>
                                    </td>
                                    <td class="px-6 py-4 text-right text-sm">
                                        <div class="flex items-center justify-end gap-3">
                                            <a href="{{ route('cocina.platillos.edit', $platillo) }}" class="font-semibold text-indigo-600 hover:text-indigo-800">
                                                Editar
                                            </a>
                                            <form action="{{ route('cocina.platillos.destroy', $platillo) }}" method="POST" onsubmit="return confirm('Eliminar este platillo?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="font-semibold text-red-600 hover:text-red-800">
                                                    Eliminar
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-10 text-center text-sm text-gray-500">
                                        No hay productos registrados.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
