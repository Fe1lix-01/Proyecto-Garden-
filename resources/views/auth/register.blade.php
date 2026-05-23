<x-guest-layout>
    <div class="mb-6">
        <h2 class="text-2xl font-black text-gray-900 tracking-tight">Crear Cuenta</h2>
        <p class="text-sm text-gray-500 mt-1">Regístrate para poder realizar tus pedidos en la plataforma.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <div>
            <x-input-label for="name" value="Nombre Completo" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="email" value="Correo Electrónico" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" value="Contraseña" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password_confirmation" value="Confirmar Contraseña" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex flex-col space-y-4 pt-2">
            <x-primary-button class="w-full justify-center py-3 text-sm font-bold uppercase tracking-wider rounded-xl">
                Registrarse
            </x-primary-button>

            <div class="text-center">
                <a class="underline text-sm text-gray-600 hover:text-indigo-600 rounded-md focus:outline-none" href="{{ route('login') }}">
                    ¿Ya tienes una cuenta? Inicia sesión
                </a>
            </div>
        </div>
    </form>
</x-guest-layout>