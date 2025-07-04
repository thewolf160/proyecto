const productos = [
    {
        codigo: "LMJSKS12",
        nombre: "Pintura Verde",
        imagen: "",
        descripcion: "verde",
        precio: "100",
        cantidad: "10"
    }
]


const contenedor = document.getElementById("items-inventario");

productos.forEach(producto => {

    const item = document.createElement("div");
    item.classList.add("item");

    item.innerHTML = `
        <img src="${producto.imagen}" alt="${producto.nombre}">
        <div id="info-producto">
            <h3>${producto.nombre}</h3>
            <p>Descripción: ${producto.descripcion} </p>
            <p>Codigo: ${producto.codigo} </p>
            <p>Precio: Bs. ${producto.precio} </p>
            <p>Cantidad Disponible: ${producto.cantidad} </p>
        </div>
    `;
    contenedor.appendChild(item);
});
