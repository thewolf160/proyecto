<?php session_start(); ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../root/css/root.css">
    <title>Document</title>
</head>
<body>
    <?php
        /* AQUI ESTA TU MALDITO ARREGLO SAPO. USA UN BUCLE PARA EXPLORARLO */
        if(!isset($_SESSION["usuario-root"]["Inventario"])){
            echo '<p class="mensaje-vacio">No hay productos</p>';
        }
            
    ?>

    

    <div id="aside"></div>
    <main id="inventario">
        <section id="btns-productos">
            <button onclick="abrirModalAgregar()">Agregar Producto</button>
            <button onclick="abrirModalEliminar()">Eliminar Producto</button>
            <button onclick="abrirModalActualizar()">Actualizar Producto</button>
        </section>
        <h2>Productos Disponibles</h2>
        <section id="barra-superior">
                <form id="form-busqueda">
                    <input type="text" id="buscar" name="buscar" placeholder="Buscar..."  usuario-root/>
                    <button type="submit">Buscar</button>
                </form>
            </section>   
        <section id="items-inventario" class="items-inventario"></section>
    </main>

    <dialog id="seccion-agregar">
        <div id="contenido-agregar">
            <form action="" id="form-agregar">
                <input type="text" placeholder="Nombre">
                <input type="text"placeholder="Descripción">
                <input type="text" placeholder="Precio">
                <input type="text" placeholder="Codigo">
                <input type="text" placeholder="Cantidad">
                <div class="input-file-group">
                    <label for="imagen" class="custom-file-label">Seleccionar imagen</label>
                    <input type="file" class="imagen" name="imagen" accept="image/*">
                    <span id="nombre-imagen">Ningún archivo seleccionado</span>
                </div>
            </form>
            <div id="btns-agregar">
                <button type="submit" form="form-agregar">Agregar</button>
                <button onclick="cerrarModalAgregar()">Cancelar</button>
            </div>
        </div>
    </dialog>
    <dialog id="seccion-eliminar">
        <div id="contenido-eliminar">
           <form action="" id="form-eliminar">
                <label for="eliminar">Codigo del producto que desea eliminar: </label>
                <input type="text" id="eliminar" name="eliminar">     
           </form>
            <div id="btns-eliminar">
                <button type="submit" form="form-eliminar">Eliminar</button>
                <button onclick="cerrarModalEliminar()">Cancelar</button>
            </div>
        </div>
    </dialog>
    <dialog id="seccion-actualizar">
        <div id="contenido-actualizar">
            <form action="" id="form-actualizar">
                <label for="actualizar">Codigo del producto que desea actualizar:</label>
                <input type="text" id="actualizar" name="actualizar">
                <input type="text" placeholder="Nombre">
                <input type="text"placeholder="Descripción">
                <input type="text" placeholder="Precio">
                <input type="text" placeholder="Codigo">
                <input type="text" placeholder="Cantidad">
                <div class="input-file-group">
                    <label for="imagen" class="custom-file-label">Seleccionar imagen</label>
                    <input type="file" class="imagen" name="imagen" accept="image/*">
                    <span id="nombre-imagen">Ningún archivo seleccionado</span>
                </div>
            </form>
            <div id="btns-actualizar">
                <button type="submit" form="form-actualizar">Actualizar</button>
                <button onclick="cerrarModalActualizar()">Cancelar</button>
            </div>
        </div>
    </dialog>
    <script src="../root/js/aside.js"></script>
    <script src="../root/js/inventario.js"></script>
    <script src="../root/js/modales.js"></script>
    <script>
        let productos = <?php echo json_encode($_SESSION['usuario-root']['Inventario'] ?? []); ?>
    </script>
    <script>mostrarProductos(productos)</script>
</body>
</html>