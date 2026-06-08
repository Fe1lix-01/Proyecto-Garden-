<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="icon" type="image/jpeg" href="{{ asset('img/garden.jpeg') }}">

        <title>{{ config('app.name', 'Dream Garden Polanco') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=outfit:400,500,600,700,800,900|inter:400,500,600,700,800&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        @php
            $isKitchen = Auth::check() && Auth::user()->esCocinero();
        @endphp

        <div class="min-h-screen gf-bg">
            @include('layouts.navigation')

            <div class="pt-16 {{ $isKitchen ? 'md:pl-72' : '' }}">
                @isset($header)
                    <header class="border-b border-[#e4beb4] bg-[#fbf9f7]/90 backdrop-blur">
                        <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endisset

                <main>
                    @if(session('success'))
                        <div class="mx-auto max-w-7xl px-4 pt-5 sm:px-6 lg:px-8">
                            <div class="rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm font-semibold text-green-800" role="alert">
                                {{ session('success') }}
                            </div>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="mx-auto max-w-7xl px-4 pt-5 sm:px-6 lg:px-8">
                            <div class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-semibold text-red-800" role="alert">
                                {{ session('error') }}
                            </div>
                        </div>
                    @endif

                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>
