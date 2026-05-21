<x-app-layout>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Mis Órdenes</h1>
        
        <table class="min-w-full bg-white border">
            <thead>
                <tr class="bg-gray-200">
                    <th class="py-2 px-4 border">Fecha y Hora</th>
                    <th class="py-2 px-4 border">Estado</th>
                    <th class="py-2 px-4 border">Total</th>
                </tr>
            </thead>
            <tbody>
                <!-- @foreach($ordenes as $orden) -->
                <tr class="text-center">
                    <td class="py-2 px-4 border">2026-04-30 14:30</td>
                    <!-- Aquí puedes aplicar la lógica de colores tipo semáforo del "Nivel Extra" -->
                    <td class="py-2 px-4 border text-yellow-600 font-bold">En Preparación</td>
                    <td class="py-2 px-4 border">$300.00</td>
                </tr>
                <!-- @endforeach -->
            </tbody>
        </table>
    </div>
</x-app-layout>