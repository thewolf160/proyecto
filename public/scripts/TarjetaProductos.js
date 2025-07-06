function MostrarProductos() {
    const contenedor = document.getElementById("contenedor-productos");

    if (!Array.isArray(productos) || productos.length === 0) {
        contenedor.innerHTML = '<p class="mensaje-vacio">No hay productos disponibles</p>';
        return;
    }

    let html = '';
    
    productos.forEach((producto, index) => {
        html += `
        <section class="rejilla-productos" aria-live="polite" aria-label="Lista de pinturas disponibles">
            <article class="tarjeta-producto" role="group" aria-labelledby="prod${index}-titulo">
                <img src="${producto.img ?? ''}" alt="${producto.nombre_producto ?? ''}">
                <h2>${producto.nombre_producto ?? ''}</h2>
                <p hidden>${producto.stock ?? '0'}</p>
                <p hidden>${producto.id ?? ''}</p>
                <p>Precio: ${producto.precio ?? '0'}</p>
                <p>${producto.descripcion ?? ''}</p>
                <button type="button" onclick="if(logeado){}else{window.location.href='./../views/registro.php'}">
                    Enviar al carrito
                </button>
            </article>
        </section>
        `;
    });

    contenedor.innerHTML = html;
}
