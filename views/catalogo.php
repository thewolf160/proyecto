<?php session_start(); ?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PincOs - Catalogo</title>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../public/css/catalogo_estilos.css">
  <link rel="icon" type="image/png" href="../public/imagenes/icon.png">
</head>

<body>

  <div id="navbar"></div>

  <main>
    <h1>Pinturas</h1>

    <div class="contenedor-busqueda" role="search">
      <span class="material-icons" aria-hidden="true">search</span>
      <form action="../controllers/controllers_product/controlador_producto.php" method="POST">
        <input type="hidden" name="seccion" value="BusquedaNombres">
        <input type="hidden" name="tipoUsuario" value="usuario">
        <input type="text" name="IBusqueda">
        <input type="submit" value="Buscar">
      </form>
    </div>

    <form action="../controllers/controllers_product/controlador_producto.php" method="POST">
      <input type="hidden" name="seccion" value="Catalogo">
      <input type="submit" name="categoria" value="Todo">
      <input type="submit" name="categoria" value="Domestica">
      <input type="submit" name="categoria" value="Industrial">
      <input type="submit" name="categoria" value="Madera">
      <input type="submit" name="categoria" value="Arquitectonica">
    </form>

    <section id="contenedor-productos"></section>
    
    <dialog id="modulo-mensajesesion">
      <div id="contenido">
        <article>
          <p>Para agregar productos al carrito, primero debes iniciar sesión en tu cuenta.</p>
        </article>
        <div>
          <button onclick="window.location.href='inicio_sesion.php'">Iniciar Sesión</button>
          <button onclick="cerrarModal()">Cerrar</button> 
        </div>
      </div>
    </dialog>

    <?php
      if (isset($_SESSION["Inicio_Sesion"]["usuario"])) {
        echo "<script src='../public/scripts/navbar2.js'></script>";
      } else {
        echo "<script src='../public/scripts/navbar.js'></script>";
      }
    ?>

    <script>let logeado = <?php echo isset($_SESSION["Inicio_Sesion"]["usuario"]) ? 'true' : 'false'; ?>;</script>
    <script>let productos = <?php echo json_encode($_SESSION['Catalogo']['productos'] ?? []); ?>;</script>
    <script  src="../public/scripts/TarjetaProductos2.js"></script>
    <script>mostrarProductos(productos);</script>
  </main>
</body>

</html>