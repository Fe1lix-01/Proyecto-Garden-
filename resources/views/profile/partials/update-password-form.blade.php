<section class="space-y-6">
    <header>
        <h3 class="text-xl font-bold text-gray-900 tracking-tight">
            Actualizar Contraseña
        </h3>
        <p class="mt-1 text-sm text-gray-500">
            Asegúrate de que tu cuenta use una contraseña larga y aleatoria para mantener la seguridad.
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="space-y-4 max-w-xl">
        @csrf
        @method('put')

        <div>
            <x-input-label for="update_password_current_password" value="Contraseña Actual" />
            <x-text-input id="update_password_current_password" name="current_password" type="password" class="block mt-1 w-full" autocomplete="current-password" />
            <x-input-error class="mt-2" :messages="$errors->updatePassword->get('current_password')" />
        </div>

        <div>
            <x-input-label for="update_password_password" value="Nueva Contraseña" />
            <x-text-input id="update_password_password" name="password" type="password" class="block mt-1 w-full" autocomplete="new-password" />
            <x-input-error class="mt-2" :messages="$errors->updatePassword->get('password')" />
        </div>

        <div>
            <x-input-label for="update_password_password_confirmation" value="Confirmar Nueva Contraseña" />
            <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="block mt-1 w-full" autocomplete="new-password" />
            <x-input-error class="mt-2" :messages="$errors->updatePassword->get('password_confirmation')" />
        </div>

        <div class="flex items-center gap-4 pt-2">
            <x-primary-button class="px-6 py-3 text-xs font-bold uppercase tracking-wider rounded-xl">
                Actualizar Contraseña
            </x-primary-button>

            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)" class="text-sm font-medium text-green-600">
                    Contraseña actualizada.
                </p>
            @endif
        </div>
    </form>
</section>