<?php session_start(); ?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../root/css/root.css">

    <title>Gestor de Inventario</title>
</head>

<body>
    <div id="aside"></div>
    <main id="inventario">
        <section id="btns-productos">
            <button onclick="abrirModalAgregar()">
                <i class="fas fa-plus"></i> Agregar <!-- Icono + texto -->
            </button>
            <button onclick="abrirModalEliminar()">
                <i class="fas fa-trash"></i> Eliminar
            </button>
            <button onclick="abrirModalActualizar()">
                <i class="fas fa-sync"></i> Actualizar
            </button>
        </section>

        <section id="barra-superior">
            <h2>Productos Disponibles</h2> <!-- Moví el título aquí -->
            <form id="form-busqueda" method="POST" action="../controllers/controllers_product/controlador_producto.php">
                <input type="hidden" name="seccion" value="BusquedaNombres">
                <input type="hidden" name="tipoUsuario" value="root">
                <div class="search-container">
                    <input type="text" id="buscar" name="IBusqueda" placeholder="Buscar productos...">
                    <button type="submit">
                        <i class="fas fa-search"></i> <!-- Icono de lupa -->
                    </button>
                </div>
            </form>
        </section>

        <section>
            <form action="../controllers/controllers_product/controlador_producto.php" method="POST">
                <input type="hidden" name="seccion" value="Inventario">
                <input type="submit" value="Ver Todos">
            </form>
        </section>

        <section id="items-inventario" class="items-inventario"></section>
    </main>

    <!-- Modal Agregar -->
    <dialog id="seccion-agregar">
        <div id="contenido-agregar">
            <h2><i class="fas fa-plus-circle"></i> Agregar Producto</h2>
            <form id="form-agregar" method="POST" action="../controllers/controllers_product/controlador_producto.php">
                <input type="hidden" name="seccion" value="agregar_producto">

                <div class="input-group">
                    <label for="nombre"><i class="fas fa-tag"></i> Nombre</label>
                    <input type="text" id="nombre" name="INombreProducto">
                </div>

                <div class="input-group">
                    <label for="descripcion"><i class="fas fa-align-left"></i> Descripción</label>
                    <input type="text" id="descripcion" placeholder="Detalles del producto" name="IDescripcion">
                </div>

                <div class="input-group">
                    <label for="categoria"><i class="fas fa-align-left"></i> Categoria</label>
                    <input list="categorias-inp" type="text" id="categoria" placeholder="Categoria Del Producto" name="ICategoria">
                    <datalist id="categorias-inp">
                        <option value="Domestica"></option>
                        <option value="Arquitectonica"></option>
                        <option value="Industrial"></option>
                        <option value="Madera"></option>
                    </datalist>
                </div>

                <div class="input-group">
                    <label for="precio"><i class="fas fa-dollar-sign"></i> Precio</label>
                    <input type="text" id="precio" placeholder="0,00" name="IPrecio">
                </div>

                <div class="input-group">
                    <label for="codigo"><i class="fas fa-barcode"></i> Código</label>
                    <input type="text" id="codigo" placeholder="ID único" name="ICodigo">
                </div>

                <div class="input-group">
                    <label for="cantidad"><i class="fas fa-boxes"></i> Cantidad</label>
                    <input type="text" id="cantidad" placeholder="En stock" name="IStock">
                </div>
                <!--<div class="input-group">
                    <label><i class="fas fa-image"></i> Imagen</label>
                    <label for="imagen" class="custom-file-label">
                        <i class="fas fa-upload"></i> Seleccionar archivo
                    </label>
                    <input type="file" id="imagen" name="imagen" accept="image/*" style="display:none">
                    <span id="nombre-imagen-agregar">Ningún archivo seleccionado</span>
                </div>-->
            </form>
            <div id="btns-agregar">
                <button type="submit" form="form-agregar">
                    <i class="fas fa-save"></i> Guardar
                </button>
                <button onclick="cerrarModalAgregar()">
                    <i class="fas fa-times"></i> Cancelar
                </button>
            </div>
        </div>
    </dialog>

    <!-- Modal Eliminar -->
    <dialog id="seccion-eliminar">
        <div id="contenido-eliminar">
            <h2><i class="fas fa-trash-alt"></i> Eliminar Producto</h2>
            <form id="form-eliminar" method="POST" action="../controllers/controllers_product/controlador_producto.php">
                <input type="hidden" name="seccion" value="EliminarProducto">
                <div class="input-group">
                    <label for="codigo-eliminar"><i class="fas fa-search"></i> Buscar por código</label>
                    <input type="text" id="codigo-eliminar" name="codigo" placeholder="Ingrese el código del producto">
                </div>
                <div class="preview-eliminar">
                    <img src="" alt="Vista previa" id="preview-eliminar" style="display:none; max-width:100%; border-radius:8px; margin:10px 0;">
                    <p id="info-eliminar" style="color:#64748b; font-size:0.9rem; text-align:center;">
                        <i class="fas fa-info-circle"></i> Aca se mostrará la vista previa del producto eliminado.
                    </p>
                </div>
            </form>
            <div id="btns-eliminar">
                <button type="submit" form="form-eliminar" id="btn-confirmar-eliminar">
                    <i class="fas fa-check-circle"></i> Confirmar
                </button>
                <button onclick="cerrarModalEliminar()">
                    <i class="fas fa-times"></i> Cancelar
                </button>
            </div>
        </div>
    </dialog>

    <!-- Modal Actualizar -->
    <dialog id="seccion-actualizar">
        <div id="contenido-actualizar">
            <h2><i class="fas fa-sync-alt"></i> Actualizar Producto</h2>
            <form id="form-actualizar" method="POST" action="../controllers/controllers_product/controlador_producto.php">
                
                <input type="hidden" name="seccion" value="modificar_producto">

                <div class="input-group">
                    <label for="codigo-actualizar"><i class="fas fa-search"></i> Código del producto</label>
                    <input type="text" id="codigo-actualizar" placeholder="Ingrese el código existente" name="ICodigo">
                </div>
                <div class="input-group">
                    <label for="nombre-act"><i class="fas fa-tag"></i> Nuevo nombre</label>
                    <input type="text" id="nombre-act" placeholder="Nombre actualizado" name="INombreProducto">
                </div>
                <div class="input-group">
                    <label for="descripcion-act"><i class="fas fa-align-left"></i> Nueva descripción</label>
                    <input type="text" id="descripcion-act" placeholder="Descripción actualizada" name="IDescripcion">
                </div>
                <div class="input-group">
                    <label for="categoria-act"><i class="fas fa-align-left"></i>Nueva Categoria</label>
                    <input type="text" id="categoria-act" placeholder="Categoria Del Producto" name="ICategoria">
                </div>
                <div class="input-group">
                    <label for="precio-act"><i class="fas fa-dollar-sign"></i> Nuevo precio</label>
                    <input type="text" id="precio-act" placeholder="Precio actualizado" name="IPrecio">
                </div>
                <div class="input-group">
                    <label for="cantidad-act"><i class="fas fa-boxes"></i> Nueva cantidad</label>
                    <input type="text" id="cantidad-act" placeholder="Stock actualizado" name="IStock">
                </div>
                <!--<div class="input-group">
                    <label><i class="fas fa-image"></i> Nueva imagen</label>
                    <label for="imagen-act" class="custom-file-label">
                        <i class="fas fa-upload"></i> Cambiar imagen
                    </label>
                    <input type="file" id="imagen-act" name="imagen" accept="image/*" style="display:none">
                    <span id="nombre-imagen-actualizar">Mantener imagen actual</span>
                </div>-->
            </form>
            <div id="btns-actualizar">
                <button type="submit" form="form-actualizar">
                    <i class="fas fa-redo"></i> Actualizar
                </button>
                <button onclick="cerrarModalActualizar()">
                    <i class="fas fa-times"></i> Cancelar
                </button>
            </div>
        </div>
    </dialog>
    <script src="../root/js/aside.js"></script>
    <script src="../root/js/inventario.js"></script>
    <script src="../root/js/modales.js"></script>
    <script>
        let productos = <?php echo json_encode($_SESSION['usuario-root']['Inventario'] ?? []); ?>
    </script>
    <script>
        mostrarProductos(productos)
    </script>
</body>

</html>