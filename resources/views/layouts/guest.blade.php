<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Dream Garden Polanco') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=outfit:400,500,600,700,800,900|inter:400,500,600,700,800&display=swap" rel="stylesheet" />
        <link rel="icon" type="image/jpeg" href="{{ asset('img/garden.jpeg') }}">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="gf-bg font-sans text-[#1b1c1b] antialiased">
        <main class="flex min-h-screen items-center justify-center px-4 py-10">
            <div class="grid w-full max-w-5xl overflow-hidden rounded-2xl border border-[#e4beb4] bg-white shadow-2xl md:grid-cols-[1fr_0.9fr]">
                <section class="relative min-h-[340px] overflow-hidden bg-[#30302f] md:min-h-[620px]">
                    <img src="{{ asset('img/garden.jpeg') }}" alt="Dream Garden Polanco" class="absolute inset-0 h-full w-full object-cover opacity-80">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/25 to-transparent"></div>
                    <div class="relative z-10 flex h-full flex-col justify-between p-8 text-white">
                        <a href="{{ url('/') }}" class="w-fit rounded-full bg-white/15 px-4 py-2 text-xs font-black uppercase tracking-wide text-white backdrop-blur hover:bg-white/25">
                            Volver al inicio
                        </a>
                        <div>
                            <p class="mb-3 text-xs font-black uppercase tracking-[0.3em] text-[#ffb5a0]">Dream Garden Polanco</p>
                            <h1 class="font-display text-4xl font-black leading-none md:text-5xl">Barra, cocina y ordenes en un solo flujo.</h1>
                            <p class="mt-4 max-w-md text-sm leading-6 text-white/80">Sistema web para clientes, cocina e inventario con el ambiente de Garden.</p>
                        </div>
                    </div>
                </section>

                <section class="flex items-center p-8 md:p-12">
                    <div class="w-full">
                        {{ $slot }}
                    </div>
                </section>
            </div>
        </main>
    </body>
</html>
