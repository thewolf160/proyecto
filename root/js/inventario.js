function mostrarProductos(productos){
const contenedor = document.getElementById("items-inventario");

productos.forEach(producto => {

    const item = document.createElement("div");
    item.classList.add("item");

    item.innerHTML = `
        <img src="${producto.img}" alt="${producto.nombre}">
        <div id="info-producto">
            <h3>${producto.nombre_producto}</h3>
            <p>Codigo: ${producto.codigo} </p>
            <p>Precio: Bs. ${producto.precio} </p>
            <p>Cantidad Disponible: ${producto.stock} </p>
        </div>
    `;
    contenedor.appendChild(item);
});
}