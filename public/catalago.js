const productos = [
    {
        nombre: "Pintura",
        precio: "50",
        imagen: "../public/imagenes/arquitectonica.jpg"
    }
];

const contenedor = document.getElementById("items-carro");

productos.forEach(producto => {
    const item = document.createElement("div");
    item.classList.add("item");

    item.innerHTML = `
        <img src="${producto.imagen}" alt="${producto.nombre}">
        <div class="info">
        <h3>${producto.nombre}</h3>
        <p>${producto.precio}</p>
        </div>
    `;
    contenedor.appendChild(item);
});