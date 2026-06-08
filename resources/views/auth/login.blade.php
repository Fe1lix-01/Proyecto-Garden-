<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="mb-6">
        <p class="mb-2 text-xs font-black uppercase tracking-[0.25em] text-[#b02f00]">Acceso</p>
        <h2 class="font-display text-3xl font-black text-[#1b1c1b] tracking-tight">Iniciar sesion</h2>
        <p class="text-sm text-[#5b4039] mt-1">Ingresa tus credenciales para acceder al sistema.</p>
        <p class="text-xs text-[#907067] mt-2">Demo: cliente@example.com / password - cocinero@example.com / password</p>
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
                <input id="remember_me" type="checkbox" class="rounded border-[#e4beb4] text-[#b02f00] shadow-sm focus:ring-[#ffb5a0]" name="remember">
                <span class="ms-2 text-sm text-[#5b4039]">Recordar mi sesion</span>
            </label>
        </div>

        <div class="flex flex-col space-y-3 pt-2">
            <x-primary-button class="w-full justify-center py-3 text-sm font-bold uppercase tracking-wider rounded-xl">
                Entrar
            </x-primary-button>

            <div class="text-center">
                @if (Route::has('password.request'))
                    <a class="underline text-xs text-[#5b4039] hover:text-[#b02f00] rounded-md focus:outline-none" href="{{ route('password.request') }}">
                        ¿Olvidaste tu contraseña?
                    </a>
                @endif
            </div>
        </div>
    </form>
</x-guest-layout>
