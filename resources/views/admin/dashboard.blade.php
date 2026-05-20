<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Panel de Administración - Restaurante') }}
            </h2>
            
            <a href="{{ route('admin.platillos.index') }}" 
               class="inline-flex items-center px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs uppercase tracking-widest rounded-full shadow-sm transition ease-in-out duration-150">
                PLATILLOS
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <p class="text-lg font-medium">{{ __("Bienvenido, ") }} {{ Auth::user()->name }}.</p>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 mt-1">
                        Acceso nivel: {{ Auth::user()->role }}
                    </span>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>