<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <p class="mb-2 text-xs font-black uppercase tracking-[0.25em] text-[#b02f00]">Catalogo de productos</p>
                <h2 class="gf-title">Menu Dream Garden</h2>
                <p class="gf-subtitle mt-2">Bebidas, promociones, botellas, comida y extras listos para ordenar.</p>
            </div>

            <a href="{{ route('cliente.carrito') }}" class="gf-button-primary">
                Ver carrito
            </a>
        </div>
    </x-slot>

    <div class="pb-28 pt-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            @php
                $featured = optional($categorias->firstWhere('categoria', 'Promociones'))->platillos?->first()
                    ?? optional($categorias->first())->platillos?->first();
                $carritoTotal = collect(session('carrito', []))->sum(fn ($item) => $item['precio'] * $item['cantidad']);
                $carritoItems = collect(session('carrito', []))->sum('cantidad');
            @endphp

            <div id="mensaje-carrito" class="mb-5 hidden rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm font-bold text-green-800"></div>

            <section class="mb-8 flex gap-3 overflow-x-auto pb-2">
                <a href="#menu" class="gf-chip gf-chip-active shrink-0">Todo</a>
                @foreach($categorias as $categoria)
                    <a href="#categoria-{{ $categoria->id }}" class="gf-chip shrink-0">{{ $categoria->categoria }}</a>
                @endforeach
            </section>

            @if($featured)
                @php
                    $featuredImage = $featured->imagen ? asset('uploads/'.$featured->imagen) : asset('img/garden.jpeg');
                @endphp
                <section id="menu" class="mb-10 grid grid-cols-1 gap-6 lg:grid-cols-12">
                    <article class="group relative min-h-[340px] overflow-hidden rounded-xl shadow-lg lg:col-span-8">
                        <img src="{{ $featuredImage }}" alt="Imagen de {{ $featured->nombre }}" class="absolute inset-0 h-full w-full object-cover transition duration-700 group-hover:scale-105">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/35 to-transparent"></div>
                        <div class="relative z-10 flex h-full flex-col justify-end p-8 text-white">
                            <span class="mb-4 w-fit rounded-full bg-[#b02f00] px-4 py-2 text-xs font-black uppercase tracking-wide">Destacado</span>
                            <h3 class="font-display text-4xl font-black leading-none md:text-5xl">{{ $featured->nombre }}</h3>
                            <p class="mt-3 max-w-xl text-base leading-7 text-white/85">{{ $featured->descripcion }}</p>
                            <form class="mt-6 flex flex-col gap-3 sm:flex-row sm:items-center" data-add-to-cart>
                                @csrf
                                <input type="hidden" name="platillo_id" value="{{ $featured->id }}">
                                <input type="hidden" name="cantidad" value="1">
                                <span class="font-display text-3xl font-black text-[#ffdbd1]">${{ number_format($featured->precio, 2) }}</span>
                                <button type="submit" class="gf-button-primary bg-[#b02f00]">
                                    Agregar a orden
                                </button>
                            </form>
                        </div>
                    </article>

                    <article class="gf-card flex flex-col p-6 lg:col-span-4">
                        <div class="h-48 overflow-hidden rounded-xl">
                            <img src="{{ $featuredImage }}" alt="Imagen de {{ $featured->nombre }}" class="h-full w-full object-cover">
                        </div>
                        <div class="mt-5 flex flex-1 flex-col">
                            <p class="text-xs font-black uppercase tracking-wide text-[#b02f00]">Recomendacion</p>
                            <h3 class="mt-2 font-display text-2xl font-black text-[#1b1c1b]">{{ $featured->categoria?->categoria ?? 'Carta' }}</h3>
                            <p class="mt-2 text-sm leading-6 text-[#5b4039]">Elige tus productos y envia la orden directo a cocina/barra.</p>
                            <a href="#categoria-{{ $featured->categoria_id }}" class="gf-button-secondary mt-auto">
                                Ver seccion
                            </a>
                        </div>
                    </article>
                </section>
            @endif

            @forelse($categorias as $categoria)
                <section id="categoria-{{ $categoria->id }}" class="mb-10 scroll-mt-24">
                    <div class="mb-4 flex items-center justify-between">
                        <div>
                            <h3 class="font-display text-2xl font-black text-[#1b1c1b]">{{ $categoria->categoria }}</h3>
                            <p class="text-sm text-[#5b4039]">{{ $categoria->descripcion }}</p>
                        </div>
                        <span class="gf-chip">{{ $categoria->platillos->count() }} items</span>
                    </div>

                    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-4">
                        @foreach($categoria->platillos as $platillo)
                            @php
                                $platilloImagen = $platillo->imagen ? asset('uploads/'.$platillo->imagen) : asset('img/garden.jpeg');
                            @endphp
                            <article class="gf-card flex flex-col p-5">
                                <div class="relative mb-4 aspect-[4/3] overflow-hidden rounded-xl bg-[#30302f]">
                                    <img src="{{ $platilloImagen }}" alt="Imagen de {{ $platillo->nombre }}" class="h-full w-full object-cover transition duration-500 hover:scale-105">
                                    <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/80 to-transparent p-4">
                                        <span class="rounded-full bg-white/90 px-3 py-1 text-xs font-black uppercase tracking-wide text-[#5b4039]">{{ $categoria->categoria }}</span>
                                    </div>
                                </div>

                                <div class="flex flex-1 flex-col">
                                    <div class="mb-3 flex items-start justify-between gap-3">
                                        <h4 class="font-display text-xl font-black text-[#1b1c1b]">{{ $platillo->nombre }}</h4>
                                        <span class="rounded-md bg-[#efedec] px-2 py-1 text-xs font-bold text-[#5b4039]">{{ $categoria->categoria }}</span>
                                    </div>
                                    <p class="min-h-[72px] text-sm leading-6 text-[#5b4039]">{{ $platillo->descripcion }}</p>
                                    <p class="mt-4 font-display text-2xl font-black text-[#b02f00]">${{ number_format($platillo->precio, 2) }}</p>

                                    <form class="mt-4 flex items-center gap-2" data-add-to-cart>
                                        @csrf
                                        <input type="hidden" name="platillo_id" value="{{ $platillo->id }}">
                                        <input type="number" name="cantidad" value="1" min="1" max="20" class="gf-input h-11 w-20 px-2 py-2 text-center">
                                        <button type="submit" class="gf-button-primary h-11 flex-1 px-3 py-2">
                                            Agregar
                                        </button>
                                    </form>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </section>
            @empty
                <div class="gf-panel p-10 text-center text-[#5b4039]">
                    No hay productos disponibles en este momento.
                </div>
            @endforelse
        </div>
    </div>

    @if($carritoItems > 0)
        <a href="{{ route('cliente.carrito') }}" class="fixed bottom-6 right-6 z-40 flex items-center gap-4 rounded-full bg-[#b02f00] px-6 py-4 text-white shadow-2xl transition hover:scale-[1.02]">
            <span class="text-2xl">🛒</span>
            <span class="text-left">
                <span class="block text-xs font-bold uppercase opacity-80">Checkout</span>
                <span class="block font-display text-xl font-black">${{ number_format($carritoTotal, 2) }}</span>
            </span>
            <span class="rounded-full bg-[#ff5722] px-3 py-1 text-xs font-black text-[#541200]">{{ $carritoItems }} items</span>
        </a>
    @endif

    <script>
        document.querySelectorAll('[data-add-to-cart]').forEach((form) => {
            form.addEventListener('submit', async (event) => {
                event.preventDefault();

                const formData = new FormData(form);
                const button = form.querySelector('button[type="submit"]');
                const mensaje = document.getElementById('mensaje-carrito');
                const originalText = button.textContent;
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
                    button.textContent = originalText;
                }
            });
        });
    </script>
</x-app-layout>
