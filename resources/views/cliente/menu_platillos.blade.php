<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-1 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <h2 class="text-xl font-bold leading-tight text-stone-900">Menu Dream Garden</h2>
                <p class="text-sm text-stone-500">Selecciona bebidas, promociones, botellas, comida o extras.</p>
            </div>

            <a href="{{ route('cliente.carrito') }}" class="inline-flex items-center justify-center rounded-md bg-emerald-700 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-emerald-800">
                Ver carrito
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mb-6 overflow-hidden rounded-md border border-emerald-200 bg-white shadow-sm">
                <div class="grid grid-cols-1 md:grid-cols-[280px_1fr]">
                    <img src="{{ asset('img/garden.jpeg') }}" alt="Dream Garden Polanco" class="h-56 w-full object-cover md:h-full">
                    <div class="p-6">
                        <p class="text-xs font-black uppercase tracking-[0.25em] text-emerald-700">Dream Garden Polanco</p>
                        <h3 class="mt-2 text-2xl font-black text-stone-950">Carta de barra y comida</h3>
                        <p class="mt-2 max-w-2xl text-sm leading-6 text-stone-600">
                            Bebidas preparadas, promociones para compartir, botellas populares, comida casual y extras.
                        </p>
                    </div>
                </div>
            </div>

            <div id="mensaje-carrito" class="mb-4 hidden rounded-md border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800"></div>

            @forelse($categorias as $categoria)
                <section class="mb-10">
                    <div class="mb-4 flex items-center justify-between border-b border-gray-200 pb-2">
                        <h3 class="text-lg font-extrabold uppercase tracking-wide text-stone-800">{{ $categoria->categoria }}</h3>
                        <span class="text-xs font-semibold text-stone-500">{{ $categoria->platillos->count() }} disponibles</span>
                    </div>

                    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach($categoria->platillos as $platillo)
                            <article class="flex min-h-[230px] flex-col justify-between rounded-md border border-emerald-100 bg-white p-5 shadow-sm">
                                <div>
                                    <div class="flex items-start justify-between gap-4">
                                        <h4 class="text-lg font-bold text-stone-900">{{ $platillo->nombre }}</h4>
                                        <span class="shrink-0 rounded-full bg-emerald-100 px-2.5 py-1 text-xs font-bold text-emerald-700">Disponible</span>
                                    </div>
                                    <p class="mt-2 min-h-[48px] text-sm leading-6 text-stone-600">{{ $platillo->descripcion }}</p>
                                    <p class="mt-3 text-2xl font-black text-stone-950">${{ number_format($platillo->precio, 2) }}</p>
                                </div>

                                <form class="mt-5 flex items-center gap-3 border-t border-gray-100 pt-4" data-add-to-cart>
                                    @csrf
                                    <input type="hidden" name="platillo_id" value="{{ $platillo->id }}">

                                    <label for="cantidad_{{ $platillo->id }}" class="sr-only">Cantidad</label>
                                    <input
                                        id="cantidad_{{ $platillo->id }}"
                                        type="number"
                                        name="cantidad"
                                        value="1"
                                        min="1"
                                        max="20"
                                        class="h-10 w-20 rounded-md border-stone-300 text-center text-sm shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                                    >

                                    <button type="submit" class="h-10 flex-1 rounded-md bg-emerald-700 px-4 text-sm font-bold text-white shadow-sm hover:bg-emerald-800">
                                        Agregar
                                    </button>
                                </form>
                            </article>
                        @endforeach
                    </div>
                </section>
            @empty
                <div class="rounded-md border border-dashed border-gray-300 bg-white p-10 text-center text-gray-500">
                    No hay platillos disponibles en este momento.
                </div>
            @endforelse
        </div>
    </div>

    <script>
        document.querySelectorAll('[data-add-to-cart]').forEach((form) => {
            form.addEventListener('submit', async (event) => {
                event.preventDefault();

                const formData = new FormData(form);
                const button = form.querySelector('button[type="submit"]');
                const mensaje = document.getElementById('mensaje-carrito');
                button.disabled = true;
                button.textContent = 'Agregando...';

                try {
                    const response = await fetch('{{ route('cliente.carrito.agregar') }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                        },
                        body: formData,
                    });

                    const data = await response.json();

                    if (response.ok && data.success) {
                        window.dispatchEvent(new CustomEvent('carrito-actualizado', {
                            detail: { totalItems: data.totalItems },
                        }));

                        mensaje.textContent = data.message;
                        mensaje.classList.remove('hidden');
                    }
                } finally {
                    button.disabled = false;
                    button.textContent = 'Agregar';
                }
            });
        });
    </script>
</x-app-layout>
