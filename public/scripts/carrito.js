function mostrarProductosCarrito(){
    const contenedor = document.getElementById("items-carro");
    let carrito = JSON.parse(sessionStorage.getItem('carrito')) || [];
    
    contenedor.innerHTML = '';

    if(carrito.length === 0){
        contenedor.innerHTML = '<p class="mensaje-vacio">El carrito está vacío</p>';
        return;
    }

carrito.forEach(producto => {
    
    const item = document.createElement("div");
    item.classList.add("item");

    item.innerHTML = `
        <img src="${producto.img ?? ''}" alt="${producto.nombre_producto}">
        <div class="info">
            <h3>${producto.nombre_producto}</h3>
            <p>Bs. ${producto.precio}</p>
        </div>
        <div class="cantidad">
        <button class="restar">-</button>
        <span class="contador">${producto.cantidad || 1}</span>
        <button class="sumar">+</button>
        </div>

        <button class="eliminar"><img src="../public/imagenes/iconeliminar.png" alt="icono"></button>
        
    `;
    contenedor.appendChild(item);

    const botonSumar = item.querySelector('.sumar');
    const botonRestar = item.querySelector('.restar');
    const botonEliminar = item.querySelector('.eliminar');
    const contador = item.querySelector('.contador');

    botonSumar.addEventListener('click', () => {
        let cantidad = parseInt(contador.textContent);
        contador.textContent = cantidad + 1;
        actualizarCantidad(producto.id, cantidad + 1);
    });

    botonRestar.addEventListener('click', () =>{
        let cantidad = parseInt(contador.textContent);
        if(cantidad > 1){
            contador.textContent = cantidad - 1;
            actualizarCantidad(producto.id, cantidad - 1);
        }
    });

    botonEliminar.addEventListener('click', () => {
        eliminarProducto(producto.id);
        item.remove();
    });
});
    calcularTotal();
}

function actualizarCantidad(id, nuevaCantidad){
    let carrito = JSON.parse(sessionStorage.getItem('carrito')) || [];
    const producto = carrito.find(item => item.id === id);

    if (producto) {
        producto.cantidad = nuevaCantidad,
        sessionStorage.setItem('carrito', JSON.stringify(carrito));
        calcularTotal();
    }
}

function eliminarProducto(id) {
    let carrito = JSON.parse(sessionStorage.getItem('carrito')) || [];
    carrito = carrito.filter(item => item.id !== id);
    sessionStorage.setItem('carrito', JSON.stringify(carrito));
    calcularTotal();
}

function calcularTotal() {
    let carrito = JSON.parse(sessionStorage.getItem('carrito')) || [];
    const precioTotal = carrito.reduce((total, producto) => {
        return total + (Number(producto.precio) * (producto.cantidad || 1));
    }, 0);
    
    document.getElementById('total').textContent = `Bs ${precioTotal.toFixed(2)}`;
}

document.addEventListener('DOMContentLoaded', mostrarProductosCarrito);
