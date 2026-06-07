<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Dream Garden Polanco') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,800" rel="stylesheet" />

        <link rel="icon" type="image/jpeg" href="{{ asset('img/garden.jpeg') }}">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased bg-stone-100 flex items-center justify-center min-h-screen p-4">
        
        <div class="w-full max-w-4xl bg-white shadow-2xl rounded-lg overflow-hidden flex flex-col md:flex-row min-h-[550px] border border-emerald-100">
            
            <div class="w-full md:w-1/2 bg-stone-950 flex flex-col items-center justify-center p-8 border-b md:border-b-0 md:border-l border-emerald-900 shrink-0">
                <div class="w-40 h-40 md:w-64 md:h-64 flex items-center justify-center overflow-hidden rounded-lg shadow-xl border-4 border-emerald-800 transform hover:scale-105 transition duration-300">
                    <img src="{{ asset('img/garden.jpeg') }}" alt="Dream Garden Polanco" class="w-full h-full object-cover">
                </div>
                <div class="mt-6 text-center hidden md:block">
                    <h2 class="text-white text-2xl font-black tracking-tight">Dream Garden Polanco</h2>
                    <p class="text-emerald-200 text-sm mt-1">Cocteles, botellas y comida casual</p>
                </div>
            </div>

            <div class="flex-1 p-8 sm:p-12 flex flex-col justify-center bg-white">
                <div class="w-full max-w-md mx-auto">
                    
                    <div class="mb-6">
                        <a href="{{ url('/') }}" class="text-xs font-bold uppercase tracking-wider text-gray-400 hover:text-indigo-600 transition">
                            &larr; Volver al inicio
                        </a>
                    </div>

                    <div class="prose">
                        {{ $slot }}
                    </div>

                </div>
            </div>

        </div>

    </body>
</html>
