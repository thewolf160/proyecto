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

    <form id="formulario_inventario" action="../controllers/controllers_product/controlador_producto.php" method="POST">
        <input type="hidden" name="seccion" value="Inventario">
    </form>

    <?php
        /* AQUI ESTA TU MALDITO ARREGLO SAPO. USA UN BUCLE PARA EXPLORARLO */
        $_SESSION["usuario-root"]["productos"];
    ?>

    <div id="aside"></div>
    <main id="inventario">
        <section id="btns-productos">
            <button onclick="abrirModalAgregar()">Agregar Producto</button>
            <button>Eliminar Producto</button>
            <button>Actualizar Producto</button>
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

    <?php
        if(!isset($_SESSION["usuario-root"]["productos"])){
            echo '<p class="mensaje-vacio">No hay productos</p>';
        }
    ?>

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
    <input type="file" id="imagen" name="imagen" accept="image/*">
    <span id="nombre-imagen">Ningún archivo seleccionado</span>
        </div>
            </form>
            <div id="btns-agregar">
                <button type="submit" form="form-agregar">Aceptar</button>
                <button onclick="cerrarModalAgregar()">Cancelar</button>
            </div>
        </div>
    </dialog>
    <script src="/root/js/aside.js"></script>
    <script src="/root/js/inventario.js"></script>
    <script src="/root/js/modales.js"></script>
    <script src="/root/js/events.js"></script>
</body>
</html>