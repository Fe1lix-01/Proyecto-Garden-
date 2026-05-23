<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Sapos Guapos Pizzería') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,600,700,800,900" rel="stylesheet" />

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <style>
                /*! tailwindcss v4.0.7 | MIT License | https://tailwindcss.com */
                @layer theme {
                    :root, :host {
                        --font-sans: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;
                        --color-gray-50: oklch(.985 .002 247.839);
                        --color-gray-100: oklch(.967 .003 264.542);
                        --color-gray-200: oklch(.928 .006 264.531);
                        --color-gray-300: oklch(.872 .01 258.338);
                        --color-gray-600: oklch(.551 .027 264.364);
                        --color-gray-700: oklch(.373 .034 259.733);
                        --color-gray-800: oklch(.278 .033 256.848);
                        --color-gray-900: oklch(.21 .034 264.665);
                        --color-black: #000;
                        --color-white: #fff;
                        --spacing: .25rem;
                        --radius-lg: .5rem;
                        --radius-xl: .75rem;
                        --radius-2xl: 1rem;
                        --radius-3xl: 1.5rem;
                        --shadow-md: 0 4px 6px -1px rgba(0,0,0,0.1), 0 2px 4px -2px rgba(0,0,0,0.1);
                        --shadow-lg: 0 10px 15px -3px rgba(0,0,0,0.1), 0 4px 6px -4px rgba(0,0,0,0.1);
                        --shadow-xl: 0 20px 25px -5px rgba(0,0,0,0.1), 0 8px 10px -6px rgba(0,0,0,0.1);
                        --shadow-2xl: 0 25px 50px -12px rgba(0,0,0,0.25);
                        --drop-shadow-lg: 0 10px 8px rgba(0,0,0,0.04), 0 4px 3px rgba(0,0,0,0.1);
                    }
                }
                @layer base {
                    *, :after, :before { box-sizing: border-box; border: 0 solid; margin: 0; padding: 0; }
                    html { line-height: 1.5; font-family: var(--font-sans); }
                    body { background-color: #f9fafb; color: #111827; -webkit-font-smoothing: antialiased; }
                    a { text-decoration: inherit; color: inherit; }
                    img { display: block; max-width: 100%; height: auto; }
                    [hidden] { display: none !important; }
                }
                @layer utilities {
                    .flex { display: flex; }
                    .grid { display: grid; }
                    .hidden { display: none; }
                    .min-h-screen { min-height: 100vh; }
                    .w-full { width: 100%; }
                    .flex-col { flex-direction: column; }
                    .items-center { align-items: center; }
                    .justify-center { justify-content: center; }
                    .justify-end { justify-content: flex-end; }
                    .gap-3 { gap: calc(var(--spacing)*3); }
                    .gap-4 { gap: calc(var(--spacing)*4); }
                    .gap-8 { gap: calc(var(--spacing)*8); }
                    .rounded-3xl { border-radius: var(--radius-3xl); }
                    .rounded-full { border-radius: 9999px; }
                    .shadow-2xl { box-shadow: var(--shadow-2xl); }
                    .drop-shadow-lg { filter: drop-shadow(0 10px 8px rgba(0,0,0,0.1)) drop-shadow(0 4px 3px rgba(0,0,0,0.1)); }
                    .bg-white { background-color: var(--color-white); }
                    .bg-gray-100 { background-color: #f3f4f6; }
                    .bg-indigo-600 { background-color: #4f46e5; }
                    .hover\:bg-indigo-700:hover { background-color: #4338ca; }
                    .bg-gray-900 { background-color: #111827; }
                    .hover\:bg-gray-800:hover { background-color: #1f2937; }
                    .p-6 { padding: calc(var(--spacing)*6); }
                    .p-8 { padding: calc(var(--spacing)*8); }
                    .p-12 { padding: calc(var(--spacing)*12); }
                    .px-8 { padding-inline: calc(var(--spacing)*8); }
                    .py-4 { padding-block: calc(var(--spacing)*4); }
                    .text-center { text-align: center; }
                    .text-sm { font-size: 0.875rem; }
                    .text-base { font-size: 1rem; }
                    .text-lg { font-size: 1.125rem; }
                    .text-4xl { font-size: 2.25rem; }
                    .text-5xl { font-size: 3rem; }
                    .font-medium { font-weight: 500; }
                    .font-semibold { font-weight: 600; }
                    .font-bold { font-weight: 700; }
                    .font-extrabold { font-weight: 800; }
                    .font-black { font-weight: 900; }
                    .tracking-tight { letter-spacing: -0.025em; }
                    .tracking-tighter { letter-spacing: -0.05em; }
                    .text-gray-500 { color: #6b7280; }
                    .text-gray-600 { color: #4b5563; }
                    .text-gray-900 { color: #111827; }
                    .text-indigo-600 { color: #4f46e5; }
                    .text-white { color: var(--color-white); }
                    .transition { transition-property: all; transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1); transition-duration: 150ms; }
                    .duration-300 { transition-duration: 300ms; }
                    .scale-100 { --tw-scale-x: 1; --tw-scale-y: 1; transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y)); }
                    .hover\:scale-105:hover { --tw-scale-x: 1.05; --tw-scale-y: 1.05; transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y)); }
                    .object-cover { object-fit: cover; }
                    /* Clases para el tamaño de la imagen */
                    .max-w-sm { max-width: 24rem; }
                    .w-full { width: 100%; }
                }
                
                @media (min-width: 768px) {
                    .md\:flex-row { flex-direction: row; }
                    .md\:text-left { text-align: left; }
                    .md\:p-16 { padding: calc(var(--spacing)*16); }
                    .md\:w-1\/2 { width: 50%; }
                    .md\:rounded-l-3xl { border-top-left-radius: var(--radius-3xl); border-bottom-left-radius: var(--radius-3xl); border-top-right-radius: 0; border-bottom-right-radius: 0; }
                    .md\:rounded-r-3xl { border-top-right-radius: var(--radius-3xl); border-bottom-right-radius: var(--radius-3xl); border-top-left-radius: 0; border-bottom-left-radius: 0; }
                }
            </style>
        @endif
    </head>
    <body class="flex items-center justify-center min-h-screen p-4 md:p-8 bg-gray-50">
        
        <main class="w-full max-w-7xl flex flex-col-reverse md:flex-row bg-white rounded-3xl shadow-2xl overflow-hidden">
            
            <div class="w-full md:w-1/2 p-8 sm:p-12 md:p-16 flex flex-col justify-between text-center md:text-left bg-white">
                
                <nav class="flex justify-center md:justify-start gap-6 text-sm font-semibold text-gray-600 mb-12">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="hover:text-indigo-600 transition">Panel principal</a>
                        @else
                            <a href="{{ route('login') }}" class="hover:text-indigo-600 transition">Iniciar sesión</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="hover:text-indigo-600 transition">Registrarse</a>
                            @endif
                        @endauth
                    @endif
                </nav>

                <div class="space-y-6 my-auto">
                    <h1 class="text-5xl md:text-6xl font-black tracking-tighter text-gray-900 leading-none">
                        Sapos Guapos<br>
                        <span class="text-indigo-600">Pizzería</span>
                    </h1>
                    <p class="text-lg md:text-xl text-gray-700 font-medium max-w-lg mx-auto md:mx-0">
                        Auténtico sabor desde 1994. Ingredientes frescos, masa artesanal y el toque secreto que nos hace únicos. ¡Pide ahora y siente la diferencia!
                    </p>
                    
                    <div class="pt-8 flex flex-col sm:flex-row gap-4 justify-center md:justify-start">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="inline-flex items-center justify-center bg-indigo-600 text-white font-bold py-4 px-10 rounded-full shadow-lg hover:bg-indigo-700 hover:scale-105 transition duration-300 scale-100">
                                Entrar al Sistema
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="inline-flex items-center justify-center bg-indigo-600 text-white font-bold py-4 px-10 rounded-full shadow-lg hover:bg-indigo-700 hover:scale-105 transition duration-300 scale-100">
                                Ordenar Ahora
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="inline-flex items-center justify-center bg-gray-100 text-gray-900 font-semibold py-4 px-10 rounded-full hover:bg-gray-200 transition duration-300">
                                    Crear Cuenta
                                </a>
                            @endif
                        @endauth
                    </div>
                </div>

                <footer class="mt-16 pt-8 border-t border-gray-100 text-xs text-gray-500 text-center md:text-left">
                    &copy; {{ date('Y') }} Sapos Guapos Pizzería. Sabor original que une a la familia.
                </footer>
            </div>

            <div class="w-full md:w-1/2 bg-gray-900 flex items-center justify-center p-12 md:p-16 relative overflow-hidden md:rounded-r-3xl">
                <div class="relative z-10 w-full drop-shadow-lg transform hover:scale-105 transition duration-300 scale-100">
                    <img src="{{ asset('img/sapos_guapos.jpg') }}" alt="Logo Pizzería Sapos Guapos" class="w-full h-auto object-cover rounded-2xl shadow-2xl border-4 border-gray-800">
                </div>
            </div>

        </main>

    </body>
</html>