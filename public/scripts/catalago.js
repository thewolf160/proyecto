const productos = [
    {
        nombre: "Pintura",
        precio: "50",
        imagen: "../public/imagenes/arquitectonica.jpg"
    },

    {
        nombre: "Pinturaaa",
        precio: "8000",
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
            <p>Bs. ${producto.precio}</p>
        </div>
        <div class="cantidad">
        <button class="restar">-</button>
        <span class="contador">1</span>
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
    });

    botonRestar.addEventListener('click', () =>{
        let cantidad = parseInt(contador.textContent);
        if(cantidad > 1){
            contador.textContent = cantidad - 1;
        }
    });

    botonEliminar.addEventListener('click', () => {
        item.remove();
    })
});
const precioTotal = productos.reduce((total, producto) => total + Number(producto.precio), 0);
const pedido = document.getElementById('total').textContent = precioTotal.toFixed(2);



