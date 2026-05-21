let carrito = JSON.parse(localStorage.getItem('carrito')) || [];

function agregarAlCarrito(id, nombre, precio) {
    const cantidad  = parseInt(document.getElementById('qty-${id}').value);

    // Verificamos si el plato ya está en el carrito
    const index = carrito.findIndex(item => item.id === id);

    if (index !== -1) {
        carrito[index].cantidad += cantidad;
    } else {
        carrito.push({ id, nombre, precio, cantidad });
    }

    actualizarInterfazCarrito();
    alert(`Añadido: ${nombre} (Cantidad: ${cantidad})`);
}

function actualizarInterfazCarrito() {
    localStorage.setItem('carrito', JSON.stringify(carrito));
    console.log("Carrito actual:", carrito);
 }