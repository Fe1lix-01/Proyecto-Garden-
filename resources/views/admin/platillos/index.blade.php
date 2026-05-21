<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gestión de Platillos e Inventario') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-6 flex justify-end">
                <a href="{{ route('admin.platillos.create') }}" 
                   style="background-color: #2563eb !important; color: #ffffff !important;"
                   class="inline-flex items-center font-bold py-2 px-4 rounded shadow-md text-sm uppercase tracking-wider hover:bg-blue-700 transition duration-150">
                    + Nuevo Platillo
                </a>
            </div>
            
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative shadow" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b bg-gray-50 text-gray-700 font-bold uppercase text-xs">
                                <th class="py-3 px-4">Nombre</th>
                                <th class="py-3 px-4">Categoría</th>
                                <th class="py-3 px-4">Descripción</th>
                                <th class="py-3 px-4">Precio</th>
                                <th class="py-3 px-4 text-center">Estado</th>
                                <th class="py-3 px-4 text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($platillos as $platillo)
                                <tr class="hover:bg-gray-50 transition duration-150 text-sm">
                                    <td class="py-4 px-4 font-semibold text-gray-900">{{ $platillo->nombre }}</td>
                                    <td class="py-4 px-4">
                                        <span class="bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                            {{ $platillo->categoria->categoria ?? 'Sin categoría' }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-4 text-gray-600 max-w-xs truncate">{{ $platillo->descripcion }}</td>
                                    <td class="py-4 px-4 font-bold text-gray-950">${{ number_format($platillo->precio, 2) }}</td>
                                    <td class="py-4 px-4 text-center">
                                        <form action="{{ route('admin.platillos.toggle', $platillo) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            @if($platillo->disponible)
                                                <button type="submit" class="bg-green-100 text-green-800 hover:bg-green-200 text-xs font-semibold px-3 py-1 rounded-full cursor-pointer transition duration-150">
                                                    ● Disponible
                                                </button>
                                            @else
                                                <button type="submit" class="bg-red-100 text-red-800 hover:bg-red-200 text-xs font-semibold px-3 py-1 rounded-full cursor-pointer transition duration-150">
                                                    ○ No Disponible
                                                </button>
                                            @endif
                                        </form>
                                    </td>
                                    <td class="py-4 px-4 text-center">
                                        <div class="flex justify-center items-center space-x-2">
                                            <a href="{{ route('admin.platillos.edit', $platillo) }}" class="text-blue-600 hover:text-blue-900 font-medium text-xs">
                                                Editar
                                            </a>
                                            <span class="text-gray-300">|</span>
                                            <form action="{{ route('admin.platillos.destroy', $platillo) }}" method="POST" onsubmit="return confirm('¿Seguro que quieres borrar este platillo del menú?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 font-medium text-xs">
                                                    Borrar
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-8 text-center text-gray-500 italic">
                                        No hay platillos registrados en el menú todavía.
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
