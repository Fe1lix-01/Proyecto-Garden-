<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" type="image/jpeg" href="{{ asset('img/garden.jpeg') }}">

        <title>{{ config('app.name', 'Dream Garden Polanco') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=outfit:400,500,600,700,800,900|inter:400,500,600,700,800&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="gf-bg font-sans text-[#1b1c1b] antialiased">
        <header class="fixed inset-x-0 top-0 z-50 border-b border-[#e4e2e0] bg-[#fbf9f7]/90 backdrop-blur">
            <div class="mx-auto flex h-16 max-w-7xl items-center justify-between px-5 lg:px-8">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('img/garden.jpeg') }}" alt="Dream Garden Polanco" class="h-10 w-10 rounded-full border-2 border-[#b02f00] object-cover">
                    <span class="gf-brand">Dream Garden Polanco</span>
                </div>
                <div class="flex items-center gap-3">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="gf-button-primary px-4 py-2">Sistema</a>
                    @else
                        <a href="{{ route('login') }}" class="gf-button-outline hidden px-4 py-2 sm:inline-flex">Iniciar sesion</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="gf-button-primary px-4 py-2">Crear cuenta</a>
                        @endif
                    @endauth
                </div>
            </div>
        </header>

        <main class="pt-16">
            <section class="relative min-h-[78vh] overflow-hidden">
                <img src="{{ asset('img/garden.jpeg') }}" alt="Dream Garden Polanco" class="absolute inset-0 h-full w-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/50 to-black/20"></div>

                <div class="relative z-10 mx-auto flex min-h-[78vh] max-w-7xl items-center px-6 py-16 lg:px-8">
                    <div class="max-w-3xl">
                        <p class="mb-4 inline-flex rounded-full bg-[#ff5722] px-4 py-2 text-xs font-black uppercase tracking-[0.25em] text-[#541200]">Dream Garden Polanco</p>
                        <h1 class="font-display text-5xl font-black leading-none text-white md:text-7xl">Ordenes, barra y cocina con ritmo de noche.</h1>
                        <p class="mt-6 max-w-2xl text-lg leading-8 text-white/85">
                            Carta de bebidas, promociones, botellas, comida y extras en una experiencia rapida para clientes y clara para cocina.
                        </p>
                        <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                            @auth
                                <a href="{{ url('/dashboard') }}" class="gf-button-primary">Entrar al sistema</a>
                            @else
                                <a href="{{ route('login') }}" class="gf-button-primary">Ordenar ahora</a>
                                <a href="{{ route('register') }}" class="inline-flex items-center justify-center rounded-xl border border-white/40 px-5 py-3 text-sm font-black uppercase tracking-wide text-white transition hover:bg-white/10">Registrarse</a>
                            @endauth
                        </div>
                    </div>
                </div>
            </section>

            <section class="mx-auto grid max-w-7xl grid-cols-1 gap-4 px-6 py-10 md:grid-cols-5 lg:px-8">
                @foreach(['Bebidas', 'Promociones', 'Botellas', 'Comida', 'Extras'] as $seccion)
                    <div class="gf-card p-5">
                        <p class="text-xs font-black uppercase tracking-wide text-[#b02f00]">{{ $seccion }}</p>
                        <p class="mt-2 text-sm leading-6 text-[#5b4039]">Seccion disponible en la carta digital.</p>
                    </div>
                @endforeach
            </section>
        </main>
    </body>
</html>
