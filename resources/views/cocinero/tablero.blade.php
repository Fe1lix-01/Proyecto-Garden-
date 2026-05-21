<x-app-layout>
    <div class="container mx-auto p-4">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Panel de Cocina</h1>
            <!-- Nivel Extra: Contador de órdenes -->
            <span class="bg-red-500 text-white px-3 py-1 rounded-full">3 Pendientes</span>
        </div>

        <!-- Tablero Kanban -->
        <div class="grid grid-cols-3 gap-6">
            
            <!-- Columna Pendientes -->
            <div class="bg-red-50 p-4 rounded-lg border-t-4 border-red-500">
                <h2 class="font-bold text-red-700 mb-4">Pendientes</h2>
                
                <!-- Tarjeta de Orden -->
                <div class="bg-white p-4 rounded shadow mb-4">
                    <p class="font-bold">Orden #102</p>
                    <p class="text-sm text-gray-500 mb-2">Cliente: Juan Pérez | Hora: 14:35</p>
                    <ul class="text-sm mb-4 list-disc pl-5">
                        <li>2x Hamburguesa Clásica</li>
                        <li>1x Refresco</li>
                    </ul>
                    <form action="/ordenes/102/estado" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="estado" value="en_preparacion">
                        <button class="w-full bg-yellow-500 text-white py-1 rounded hover:bg-yellow-600">
                            Preparar
                        </button>
                    </form>
                </div>
            </div>

            <!-- Columna En Preparación -->
            <div class="bg-yellow-50 p-4 rounded-lg border-t-4 border-yellow-500">
                <h2 class="font-bold text-yellow-700 mb-4">En Preparación</h2>
                <!-- Tarjeta de Orden en proceso -->
                <div class="bg-white p-4 rounded shadow mb-4">
                    <p class="font-bold">Orden #101</p>
                    <ul class="text-sm mb-4 list-disc pl-5">
                        <li>1x Ensalada César</li>
                    </ul>
                    <form action="/ordenes/101/estado" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="estado" value="lista">
                        <button class="w-full bg-green-500 text-white py-1 rounded hover:bg-green-600">
                            Marcar como Lista
                        </button>
                    </form>
                </div>
            </div>

            <!-- Columna Listas -->
            <div class="bg-green-50 p-4 rounded-lg border-t-4 border-green-500">
                <h2 class="font-bold text-green-700 mb-4">Listas para entregar</h2>
                <!-- Tarjeta de Orden lista -->
                <div class="bg-white p-4 rounded shadow mb-4 opacity-75">
                    <p class="font-bold">Orden #100</p>
                    <p class="text-sm text-green-600 font-bold mt-2">¡Completada!</p>
                </div>
            </div>

        </div>
    </div>
    
    <!-- Nivel Extra: Recarga casi en tiempo real (Recarga la página cada 30 segundos) -->
    <script>
        setTimeout(function(){
            window.location.reload();
        }, 30000);
    </script>
</x-app-layout>