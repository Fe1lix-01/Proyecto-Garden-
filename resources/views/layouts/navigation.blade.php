<nav
    x-data="{
        open: false,
        totalItems: {{ collect(session('carrito', []))->sum('cantidad') }}
    }"
    x-on:carrito-actualizado.window="totalItems = $event.detail.totalItems"
    class="fixed inset-x-0 top-0 z-50 h-16 border-b border-[#e4e2e0] bg-[#fbf9f7]/95 backdrop-blur"
>
    <div class="flex h-full items-center justify-between px-5 lg:px-8">
        <a href="{{ Auth::user()->esCocinero() ? route('cocina.ordenes.index') : route('cliente.menu') }}" class="flex items-center gap-3">
            <img src="{{ asset('img/garden.jpeg') }}" alt="Dream Garden Polanco" class="h-10 w-10 rounded-full border-2 border-[#b02f00] object-cover">
            <span class="gf-brand">Dream Garden Polanco</span>
        </a>

        @if(! Auth::user()->esCocinero())
            <div class="hidden h-full items-center gap-10 md:flex">
                <a href="{{ route('cliente.menu') }}" class="flex h-full items-center border-b-2 px-1 text-sm font-bold transition {{ request()->routeIs('cliente.menu') ? 'border-[#b02f00] text-[#b02f00]' : 'border-transparent text-[#5b4039] hover:text-[#b02f00]' }}">
                    Menu
                </a>
                <a href="{{ route('cliente.ordenes.index') }}" class="flex h-full items-center border-b-2 px-1 text-sm font-bold transition {{ request()->routeIs('cliente.ordenes.*') ? 'border-[#b02f00] text-[#b02f00]' : 'border-transparent text-[#5b4039] hover:text-[#b02f00]' }}">
                    Ordenes
                </a>
            </div>
        @endif

        <div class="hidden items-center gap-4 md:flex">
            @if(!Auth::user()->esCocinero())
                <a href="{{ route('cliente.carrito') }}" class="relative rounded-full p-2 text-[#5b4039] transition hover:bg-[#efedec]">
                    <span class="text-xl">🛒</span>
                    <span x-show="totalItems > 0" x-text="totalItems" class="absolute -right-1 -top-1 rounded-full bg-[#ff5722] px-1.5 py-0.5 text-[10px] font-black text-[#541200]"></span>
                </a>
            @endif

            <x-dropdown align="right" width="48">
                <x-slot name="trigger">
                    <button class="flex items-center gap-2 rounded-full p-2 text-[#5b4039] transition hover:bg-[#efedec]">
                        <span class="text-xl">◎</span>
                        <span class="sr-only">{{ Auth::user()->name }}</span>
                    </button>
                </x-slot>

                <x-slot name="content">
                    <x-dropdown-link :href="route('profile.edit')">Perfil</x-dropdown-link>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                            Cerrar sesion
                        </x-dropdown-link>
                    </form>
                </x-slot>
            </x-dropdown>
        </div>

        <button @click="open = ! open" class="rounded-full p-2 text-[#5b4039] transition hover:bg-[#efedec] md:hidden">
            <span class="text-2xl" x-text="open ? '×' : '☰'"></span>
        </button>
    </div>

    <div x-show="open" x-cloak class="border-t border-[#e4e2e0] bg-[#fbf9f7] px-5 py-4 shadow-lg md:hidden">
        <div class="flex flex-col gap-2">
            @if(Auth::user()->esCocinero())
                <a href="{{ route('cocina.ordenes.index') }}" class="gf-chip {{ request()->routeIs('cocina.ordenes.*') ? 'gf-chip-active' : '' }}">Cocina</a>
                <a href="{{ route('cocina.platillos.index') }}" class="gf-chip {{ request()->routeIs('cocina.platillos.*') ? 'gf-chip-active' : '' }}">Inventario</a>
            @else
                <a href="{{ route('cliente.menu') }}" class="gf-chip {{ request()->routeIs('cliente.menu') ? 'gf-chip-active' : '' }}">Menu</a>
                <a href="{{ route('cliente.carrito') }}" class="gf-chip {{ request()->routeIs('cliente.carrito') ? 'gf-chip-active' : '' }}">Carrito <span x-show="totalItems > 0" x-text="totalItems" class="ms-2"></span></a>
                <a href="{{ route('cliente.ordenes.index') }}" class="gf-chip {{ request()->routeIs('cliente.ordenes.*') ? 'gf-chip-active' : '' }}">Ordenes</a>
            @endif
            <a href="{{ route('profile.edit') }}" class="gf-chip">Perfil</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="gf-chip w-full">Cerrar sesion</button>
            </form>
        </div>
    </div>
</nav>

@if(Auth::user()->esCocinero())
    <aside class="fixed left-0 top-16 z-40 hidden h-[calc(100vh-4rem)] w-72 flex-col border-r border-[#e4e2e0] bg-[#efedec] p-5 md:flex">
        <div class="mb-8 flex items-center gap-4">
            <img src="{{ asset('img/garden.jpeg') }}" alt="Dream Garden Polanco" class="h-14 w-14 rounded-full border-2 border-[#b02f00] object-cover">
            <div>
                <p class="font-display text-lg font-black text-[#1b1c1b]">{{ Auth::user()->name }}</p>
                <p class="text-xs font-bold uppercase tracking-wide text-[#5b4039]">Barra y cocina</p>
            </div>
        </div>

        <div class="flex flex-1 flex-col gap-3">
            <a href="{{ route('cocina.ordenes.index') }}" class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-black transition {{ request()->routeIs('cocina.ordenes.*') ? 'bg-[#ff5722] text-[#541200]' : 'text-[#5b4039] hover:bg-[#e4e2e0]' }}">
                <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path d="M12 5v2" />
                    <path d="M5 14a7 7 0 0 1 14 0" />
                    <path d="M4 14h16" />
                    <path d="M6 18h12" />
                </svg>
                Cocina
            </a>
            <a href="{{ route('cocina.platillos.index') }}" class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-black transition {{ request()->routeIs('cocina.platillos.*') ? 'bg-[#ff5722] text-[#541200]' : 'text-[#5b4039] hover:bg-[#e4e2e0]' }}">
                <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path d="M4 7h16" />
                    <path d="M5 7l1.5 14h13L21 7" />
                    <path d="M9 7V5a3 3 0 0 1 6 0v2" />
                    <path d="M9 12h6" />
                </svg>
                Inventario
            </a>
            <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-black transition {{ request()->routeIs('profile.edit') ? 'bg-[#ff5722] text-[#541200]' : 'text-[#5b4039] hover:bg-[#e4e2e0]' }}">
                <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path d="M20 21a8 8 0 0 0-16 0" />
                    <circle cx="12" cy="8" r="4" />
                </svg>
                Perfil
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex w-full items-center gap-3 rounded-xl px-4 py-3 text-left text-sm font-black text-[#5b4039] transition hover:bg-[#e4e2e0]">
                    <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path d="M10 17l5-5-5-5" />
                        <path d="M15 12H3" />
                        <path d="M21 3v18" />
                    </svg>
                    Cerrar sesion
                </button>
            </form>
        </div>

        <a href="{{ route('cocina.platillos.create') }}" class="gf-button-primary w-full">
            Nuevo producto
        </a>
    </aside>
@endif
