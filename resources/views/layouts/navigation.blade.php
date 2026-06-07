<nav
    x-data="{
        open: false,
        totalItems: {{ collect(session('carrito', []))->sum('cantidad') }}
    }"
    x-on:carrito-actualizado.window="totalItems = $event.detail.totalItems"
    class="border-b border-emerald-100 bg-white"
>
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 justify-between">
            <div class="flex">
                <div class="flex shrink-0 items-center">
                    <a href="{{ Auth::user()->esCocinero() ? route('cocina.ordenes.index') : route('cliente.menu') }}">
                        <img src="{{ asset('img/garden.jpeg') }}" alt="Dream Garden Polanco" class="block h-10 w-10 rounded-full object-cover shadow">
                        <span class="ms-3 hidden text-sm font-black uppercase tracking-wide text-stone-900 lg:inline">Dream Garden</span>
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    @if(Auth::user()->esCocinero())
                        <x-nav-link :href="route('cocina.ordenes.index')" :active="request()->routeIs('cocina.ordenes.*')">
                            Ordenes
                        </x-nav-link>

                        <x-nav-link :href="route('cocina.platillos.index')" :active="request()->routeIs('cocina.platillos.*')">
                            Carta
                        </x-nav-link>
                    @else
                        <x-nav-link :href="route('cliente.menu')" :active="request()->routeIs('cliente.menu')">
                            Menu
                        </x-nav-link>

                        <x-nav-link :href="route('cliente.carrito')" :active="request()->routeIs('cliente.carrito')">
                            <span>Carrito</span>
                            <span x-show="totalItems > 0" x-text="totalItems" class="ms-2 rounded-full bg-emerald-100 px-2 py-0.5 text-xs font-bold text-emerald-700"></span>
                        </x-nav-link>

                        <x-nav-link :href="route('cliente.ordenes.index')" :active="request()->routeIs('cliente.ordenes.*')">
                            Mis ordenes
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center rounded-md border border-transparent bg-white px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition hover:text-gray-700 focus:outline-none">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ms-1">
                                <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            Perfil
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                Cerrar sesion
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center rounded-md p-2 text-gray-400 transition hover:bg-gray-100 hover:text-gray-500 focus:bg-gray-100 focus:text-gray-500 focus:outline-none">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="space-y-1 pb-3 pt-2">
            @if(Auth::user()->esCocinero())
                <x-responsive-nav-link :href="route('cocina.ordenes.index')" :active="request()->routeIs('cocina.ordenes.*')">
                    Ordenes
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('cocina.platillos.index')" :active="request()->routeIs('cocina.platillos.*')">
                    Carta
                </x-responsive-nav-link>
            @else
                <x-responsive-nav-link :href="route('cliente.menu')" :active="request()->routeIs('cliente.menu')">
                    Menu
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('cliente.carrito')" :active="request()->routeIs('cliente.carrito')">
                    Carrito
                    <span x-show="totalItems > 0" x-text="totalItems" class="ms-2 inline-flex items-center justify-center rounded-full bg-emerald-600 px-2 py-1 text-xs font-bold leading-none text-white"></span>
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('cliente.ordenes.index')" :active="request()->routeIs('cliente.ordenes.*')">
                    Mis ordenes
                </x-responsive-nav-link>
            @endif
        </div>

        <div class="border-t border-gray-200 pb-1 pt-4">
            <div class="px-4">
                <div class="text-base font-medium text-gray-800">{{ Auth::user()->name }}</div>
                <div class="text-sm font-medium text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    Perfil
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                        Cerrar sesion
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
