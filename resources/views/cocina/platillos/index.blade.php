<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-5 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <p class="mb-2 text-xs font-black uppercase tracking-[0.25em] text-[#b02f00]">Inventory management</p>
                <h2 class="gf-title">Productos de la carta</h2>
                <p class="gf-subtitle mt-2">Control de disponibilidad para clientes y cocina.</p>
            </div>

            <a href="{{ route('cocina.platillos.create') }}" class="gf-button-primary">
                Nuevo producto
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mb-6 flex gap-3 overflow-x-auto pb-2">
                <a href="{{ route('cocina.platillos.index') }}" class="gf-chip shrink-0 {{ $categoriaActual ? '' : 'gf-chip-active' }}">
                    Todo
                </a>
                @foreach($categorias as $categoria)
                    <a href="{{ route('cocina.platillos.index', ['categoria' => $categoria->id]) }}" class="gf-chip shrink-0 {{ $categoriaActual === $categoria->id ? 'gf-chip-active' : '' }}">
                        {{ $categoria->categoria }}
                    </a>
                @endforeach
            </div>

            <div class="gf-card overflow-hidden">
                <div class="hidden overflow-x-auto lg:block">
                    <table class="gf-table">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Categoria</th>
                                <th>Precio</th>
                                <th>Stock status</th>
                                <th class="text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                            @forelse($platillos as $platillo)
                                @php
                                    $platilloImagen = $platillo->imagen ? asset('uploads/'.$platillo->imagen) : asset('img/garden.jpeg');
                                @endphp
                                <tr>
                                    <td>
                                        <div class="flex items-center gap-4">
                                            <img src="{{ $platilloImagen }}" alt="Imagen de {{ $platillo->nombre }}" class="h-14 w-14 shrink-0 rounded-xl object-cover">
                                            <div>
                                                <p class="font-display text-lg font-black text-[#1b1c1b]">{{ $platillo->nombre }}</p>
                                                <p class="max-w-md truncate text-xs text-[#5b4039]">{{ $platillo->descripcion }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="rounded-md bg-[#d7e4ec] px-3 py-1 text-sm font-bold text-[#3c494f]">
                                            {{ $platillo->categoria?->categoria ?? 'Sin categoria' }}
                                        </span>
                                    </td>
                                    <td class="font-display text-lg font-black text-[#1b1c1b]">${{ number_format($platillo->precio, 2) }}</td>
                                    <td>
                                        <form action="{{ route('cocina.platillos.disponibilidad', $platillo) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="inline-flex items-center gap-3 text-sm font-bold {{ $platillo->disponible ? 'text-[#b02f00]' : 'text-[#5b4039]' }}">
                                                <span class="relative inline-flex h-7 w-12 rounded-full {{ $platillo->disponible ? 'bg-[#b02f00]' : 'bg-[#e4e2e0]' }}">
                                                    <span class="absolute top-1 h-5 w-5 rounded-full bg-white transition {{ $platillo->disponible ? 'right-1' : 'left-1' }}"></span>
                                                </span>
                                                {{ $platillo->disponible ? 'Disponible' : 'Agotado' }}
                                            </button>
                                        </form>
                                    </td>
                                    <td class="text-right">
                                        <div class="flex justify-end gap-3">
                                            <a href="{{ route('cocina.platillos.edit', $platillo) }}" class="gf-button-outline px-4 py-2">
                                                Editar
                                            </a>
                                            <form action="{{ route('cocina.platillos.destroy', $platillo) }}" method="POST" onsubmit="return confirm('Eliminar este producto?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="gf-button-danger px-4 py-2">
                                                    Eliminar
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-12 text-center text-[#5b4039]">
                                        No hay productos registrados.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="grid grid-cols-1 gap-4 p-4 lg:hidden">
                    @forelse($platillos as $platillo)
                        @php
                            $platilloImagen = $platillo->imagen ? asset('uploads/'.$platillo->imagen) : asset('img/garden.jpeg');
                        @endphp
                        <article class="rounded-xl border border-[#e4e2e0] bg-white p-4">
                            <img src="{{ $platilloImagen }}" alt="Imagen de {{ $platillo->nombre }}" class="mb-4 aspect-[16/9] w-full rounded-xl object-cover">
                            <div class="flex items-start justify-between gap-3">
                                <div>
                                    <p class="font-display text-xl font-black text-[#1b1c1b]">{{ $platillo->nombre }}</p>
                                    <p class="text-sm text-[#5b4039]">{{ $platillo->categoria?->categoria ?? 'Sin categoria' }}</p>
                                </div>
                                <p class="font-display text-xl font-black text-[#b02f00]">${{ number_format($platillo->precio, 2) }}</p>
                            </div>
                            <p class="mt-3 text-sm leading-6 text-[#5b4039]">{{ $platillo->descripcion }}</p>
                            <div class="mt-4 flex flex-wrap gap-2">
                                <form action="{{ route('cocina.platillos.disponibilidad', $platillo) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="gf-chip {{ $platillo->disponible ? 'gf-chip-active' : '' }}">
                                        {{ $platillo->disponible ? 'Disponible' : 'Agotado' }}
                                    </button>
                                </form>
                                <a href="{{ route('cocina.platillos.edit', $platillo) }}" class="gf-button-outline px-4 py-2">Editar</a>
                            </div>
                        </article>
                    @empty
                        <p class="p-6 text-center text-[#5b4039]">No hay productos registrados.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
