<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Confirmar mi Pedido') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4">Resumen de productos</h3>
                    
                    <div class="overflow-x-auto mb-6">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Platillo</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Precio Unit.</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cantidad</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Subtotal</th>
                                    <th class="px-6 py-3"></th>
                                </tr>
                            </thead>
                            <tbody id="tabla-carrito" class="bg-white divide-y divide-gray-200">
                                </tbody>
                        </table>
                    </div>

                    <div class="flex justify-between items-center border-t pt-4">
                        <div class="text-2xl font-bold text-gray-800">
                            Total: $<span id="total-pedido">0.00</span>
                        </div>
                        
                        <form id="form-confirmar" action="{{ route('ordenes.store') }}" method="POST">
                            @csrf
                            {{-- Aquí inyectaremos los datos del carrito de forma oculta --}}
                            <input type="hidden" name="items" id="items-input">
                            
                            <button type="button" onclick="confirmarCompra()" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded-lg transition">
                                Confirmar y Pagar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Script específico para esta pantalla --}}
    <script src="{{ asset('js/carrito.js') }}"></script>
    <script>
        // Función para renderizar el carrito al cargar la página
        document.addEventListener('DOMContentLoaded', () => {
            renderizarCarrito();
        });

        function renderizarCarrito() {
            const tabla = document.getElementById('tabla-carrito');
            const totalTxt = document.getElementById('total-pedido');
            let html = '';
            let total = 0;

            if (carrito.length === 0) {
                tabla.innerHTML = '<tr><td colspan="5" class="p-4 text-center">Tu carrito está vacío</td></tr>';
                return;
            }

            carrito.forEach((item, index) => {
                const subtotal = item.precio * item.cantidad;
                total += subtotal;
                html += `
                    <tr>
                        <td class="px-6 py-4">${item.nombre}</td>
                        <td class="px-6 py-4">$${item.precio.toFixed(2)}</td>
                        <td class="px-6 py-4">${item.cantidad}</td>
                        <td class="px-6 py-4 font-bold">$${subtotal.toFixed(2)}</td>
                        <td class="px-6 py-4">
                            <button onclick="eliminarDelCarrito(${index})" class="text-red-600 hover:text-red-900">Eliminar</button>
                        </td>
                    </tr>
                `;
            });

            tabla.innerHTML = html;
            totalTxt.innerText = total.toFixed(2);
            document.getElementById('items-input').value = JSON.stringify(carrito);
        }

        function eliminarDelCarrito(index) {
            carrito.splice(index, 1);
            localStorage.setItem('carrito', JSON.stringify(carrito));
            renderizarCarrito();
            actualizarContadorGlobal(); // Función que debes tener en carrito.js
        }

        function confirmarCompra() {
            if (carrito.length === 0) {
                alert("El carrito está vacío.");
                return;
            }
            if (confirm("¿Deseas confirmar tu pedido?")) {
                document.getElementById('form-confirmar').submit();
                localStorage.removeItem('carrito'); // Limpiamos tras comprar
            }
        }
    </script>
</x-app-layout>