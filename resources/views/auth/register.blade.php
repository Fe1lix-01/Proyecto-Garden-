<x-guest-layout>
    <div class="mb-6">
        <p class="mb-2 text-xs font-black uppercase tracking-[0.25em] text-[#b02f00]">Registro</p>
        <h2 class="font-display text-3xl font-black text-[#1b1c1b] tracking-tight">Crear cuenta</h2>
        <p class="text-sm text-[#5b4039] mt-1">Registrate para operar como cliente o cocinero.</p>
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
            <x-input-label for="role" value="Tipo de Usuario" />
            <select id="role" name="role" required class="block mt-1 w-full rounded-xl border-[#e4beb4] bg-white px-4 py-3 shadow-sm focus:border-[#b02f00] focus:ring-[#ffb5a0]">
                <option value="cliente" @selected(old('role', 'cliente') === 'cliente')>Cliente</option>
                <option value="cocinero" @selected(old('role') === 'cocinero')>Cocinero</option>
            </select>
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
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
                <a class="underline text-sm text-[#5b4039] hover:text-[#b02f00] rounded-md focus:outline-none" href="{{ route('login') }}">
                    ¿Ya tienes una cuenta? Inicia sesión
                </a>
            </div>
        </div>
    </form>
</x-guest-layout>
