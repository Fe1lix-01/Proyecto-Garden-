<section class="space-y-6">
    <header>
        <h3 class="text-xl font-bold text-red-600 tracking-tight">
            Eliminar Cuenta
        </h3>
        <p class="mt-1 text-sm text-gray-500">
            Una vez que elimines tu cuenta, todos sus recursos e información se borrarán de forma permanente.
        </p>
    </header>

    <x-danger-button x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')" class="px-6 py-3 text-xs font-bold uppercase tracking-wider rounded-xl">
        Eliminar Mi Cuenta
    </x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-bold text-gray-900">
                ¿Estás seguro de que deseas eliminar tu cuenta?
            </h2>

            <p class="mt-1 text-sm text-gray-500">
                Por favor, ingresa tu contraseña para confirmar que deseas borrar permanentemente tu cuenta y tus datos.
            </p>

            <div class="mt-4">
                <x-input-label for="password" value="Contraseña" class="sr-only" />
                <x-text-input id="password" name="password" type="password" class="block w-3/4 mt-1" placeholder="Ingresa tu contraseña para confirmar" />
                <x-input-error class="mt-2" :messages="$errors->userDeletion->get('password')" />
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <x-secondary-button x-on:click="$dispatch('close')" class="rounded-xl px-4 py-2">
                    Cancelar
                </x-secondary-button>

                <x-danger-button class="rounded-xl px-4 py-2">
                    Confirmar Eliminación
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>