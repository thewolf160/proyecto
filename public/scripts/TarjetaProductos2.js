function mostrarProductos(productos){
    const contenedor = document.getElementById("contenedor-productos");

if (!Array.isArray(productos) || productos.length === 0) {
        contenedor.innerHTML = '<p class="mensaje-vacio">No hay productos disponibles</p>';
        return;
    }

    productos.forEach((producto, index) => {
        const item = document.createElement("section");
        item.classList.add("rejilla-productos");

        item.innerHTML = `<article class="tarjeta-producto" role="group" aria-labelledby="prod${index}-titulo">
                <img src="${producto.img?? ''}" alt="${producto.nombre_producto ?? ''}">
                <h2>${producto.nombre_producto ?? ''}</h2>
                <p hidden>${producto.stock ?? '0'}</p>
                <p hidden>${producto.id ?? ''}</p>
                <p>Precio: ${producto.precio ?? '0'}</p>
                <p>${producto.descripcion ?? ''}</p>
                <button type="button" onclick='agregarAlCarrito(${JSON.stringify(producto)})'>
                    Enviar al carrito
                </button>
            </article>`;
            contenedor.appendChild(item);
    });
}

function agregarAlCarrito(producto){

    if(!logeado){
        document.getElementById("modulo-mensajesesion").showModal();
        return;
    } 
        
    document.getElementById("modulo-mensajeCarrito").showModal();
    
    let carrito = JSON.parse(sessionStorage.getItem('carrito')) || [];

    const productoExistente = carrito.find(item => item.id === producto.id);

    if(productoExistente){
        productoExistente.cantidad = (productoExistente.cantidad || 1) +1;
    }else{
        producto.cantidad = 1;
        carrito.push(producto);
    }

    sessionStorage.setItem('carrito', JSON.stringify(carrito));
}

function cerrarModal(){
    document.getElementById("modulo-mensajesesion").close();
}

