<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-gray-800 leading-tight tracking-tight">
            {{ __('Mi Perfil') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <div class="p-6 sm:p-10 bg-white shadow-xl rounded-3xl border border-gray-100 max-w-3xl">
                @include('profile.partials.update-profile-information-form')
            </div>

            <div class="p-6 sm:p-10 bg-white shadow-xl rounded-3xl border border-gray-100 max-w-3xl">
                @include('profile.partials.update-password-form')
            </div>

            <div class="p-6 sm:p-10 bg-white shadow-md rounded-3xl border border-red-100 max-w-3xl bg-red-50/10">
                @include('profile.partials.delete-user-form')
            </div>
            
        </div>
    </div>
</x-app-layout>