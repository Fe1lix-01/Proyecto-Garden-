<section class="space-y-6">
    <header>
        <h3 class="text-xl font-bold text-gray-900 tracking-tight">
            Información del Perfil
        </h3>
        <p class="mt-1 text-sm text-gray-500">
            Actualiza la información de tu cuenta y tu dirección de correo electrónico.
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-4 max-w-xl">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" value="Nombre Completo" />
            <x-text-input id="name" name="name" type="text" class="block mt-1 w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" value="Correo Electrónico" />
            <x-text-input id="email" name="email" type="email" class="block mt-1 w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-3 bg-yellow-50 border border-yellow-100 p-3 rounded-xl">
                    <p class="text-sm text-yellow-800">
                        Tu dirección de correo electrónico no está verificada.
                        <button form="send-verification" class="underline text-sm font-bold text-yellow-900 hover:text-black">
                            Haz clic aquí para volver a enviar el correo de verificación.
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 text-sm font-semibold text-green-600">
                            Se ha enviado un nuevo enlace de verificación a tu correo electrónico.
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4 pt-2">
            <x-primary-button class="px-6 py-3 text-xs font-bold uppercase tracking-wider rounded-xl">
                Guardar Cambios
            </x-primary-button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)" class="text-sm font-medium text-green-600">
                    Cambios guardados correctamente.
                </p>
            @endif
        </div>
    </form>
</section>