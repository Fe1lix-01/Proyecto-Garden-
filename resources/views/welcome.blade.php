<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" type="image/jpeg" href="{{ asset('img/garden.jpeg') }}">

        <title>{{ config('app.name', 'Dream Garden Polanco') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,800,900" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-stone-950 font-sans text-white antialiased">
        <main>
            <section class="relative flex min-h-[82vh] items-center overflow-hidden">
                <img
                    src="{{ asset('img/garden.jpeg') }}"
                    alt="Dream Garden Polanco"
                    class="absolute inset-0 h-full w-full object-cover"
                >
                <div class="absolute inset-0 bg-black/55"></div>

                <div class="relative z-10 mx-auto w-full max-w-7xl px-6 py-20 sm:px-8 lg:px-10">
                    <p class="mb-4 text-sm font-bold uppercase tracking-[0.35em] text-emerald-200">Bar botanico en Polanco</p>
                    <h1 class="max-w-4xl text-5xl font-black leading-none text-white sm:text-7xl lg:text-8xl">
                        Dream Garden Polanco
                    </h1>
                    <p class="mt-6 max-w-2xl text-lg font-medium leading-8 text-stone-100">
                        Cocteles, botellas, promociones y comida casual en un ambiente de jardin nocturno.
                    </p>

                    <div class="mt-9 flex flex-col gap-3 sm:flex-row">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="inline-flex items-center justify-center rounded-md bg-emerald-500 px-6 py-3 text-sm font-black uppercase text-stone-950 shadow-lg hover:bg-emerald-400">
                                Entrar al sistema
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="inline-flex items-center justify-center rounded-md bg-emerald-500 px-6 py-3 text-sm font-black uppercase text-stone-950 shadow-lg hover:bg-emerald-400">
                                Ordenar ahora
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="inline-flex items-center justify-center rounded-md border border-white/40 px-6 py-3 text-sm font-black uppercase text-white hover:bg-white/10">
                                    Crear cuenta
                                </a>
                            @endif
                        @endauth
                    </div>
                </div>
            </section>

            <section class="bg-stone-100 px-6 py-10 text-stone-950 sm:px-8 lg:px-10">
                <div class="mx-auto grid max-w-7xl grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-5">
                    <div class="rounded-md border border-emerald-200 bg-white p-5">
                        <p class="text-xs font-black uppercase text-emerald-700">Bebidas</p>
                        <p class="mt-2 text-sm text-stone-600">Cubano, Jackie Chan, Diablo, Linterna Verde, Azulito y Mango.</p>
                    </div>
                    <div class="rounded-md border border-amber-200 bg-white p-5">
                        <p class="text-xs font-black uppercase text-amber-700">Promos</p>
                        <p class="mt-2 text-sm text-stone-600">2x80, 2x140, cubeta, cerveza y vitrolero.</p>
                    </div>
                    <div class="rounded-md border border-rose-200 bg-white p-5">
                        <p class="text-xs font-black uppercase text-rose-700">Botellas</p>
                        <p class="mt-2 text-sm text-stone-600">Tequila, whisky, ron y vodka para la mesa.</p>
                    </div>
                    <div class="rounded-md border border-sky-200 bg-white p-5">
                        <p class="text-xs font-black uppercase text-sky-700">Comida</p>
                        <p class="mt-2 text-sm text-stone-600">Pizza, boneless, papas y Maruchan.</p>
                    </div>
                    <div class="rounded-md border border-violet-200 bg-white p-5">
                        <p class="text-xs font-black uppercase text-violet-700">Extras</p>
                        <p class="mt-2 text-sm text-stone-600">Cigarro y vape disponibles en barra.</p>
                    </div>
                </div>
            </section>
        </main>
    </body>
</html>
