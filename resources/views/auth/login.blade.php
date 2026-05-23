<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="mb-6">
        <h2 class="text-2xl font-black text-gray-900 tracking-tight">Iniciar Sesión</h2>
        <p class="text-sm text-gray-500 mt-1">Ingresa tus credenciales para acceder al sistema.</p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <div>
            <x-input-label for="email" value="Correo Electrónico" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" value="Contraseña" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="block">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">Recordar mi sesión</span>
            </label>
        </div>

        <div class="flex flex-col space-y-3 pt-2">
            <x-primary-button class="w-full justify-center py-3 text-sm font-bold uppercase tracking-wider rounded-xl">
                Entrar
            </x-primary-button>

            <div class="text-center">
                @if (Route::has('password.request'))
                    <a class="underline text-xs text-gray-600 hover:text-indigo-600 rounded-md focus:outline-none" href="{{ route('password.request') }}">
                        ¿Olvidaste tu contraseña?
                    </a>
                @endif
            </div>
        </div>
    </form>
</x-guest-layout>