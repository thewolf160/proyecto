<?php  session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
    <title>PincOs-Registro</title>
    <link rel="stylesheet" href="../public//css/registro.css">
    <link rel="icon" type="image/png" href="../public/imagenes/icon.png">
</head>
<body>

    <a href="inicio.php" id="retroceder"><img src="../public/imagenes/Flechaatras1.png" alt="Flecha que te dirige al inicio"></a>

    <div id="LadoIzquierdo">

        <p>¡¡CREA TU CUENTA AQUI!!</p>
        <p>Para realizar tus primeras compras en linea.</p>

    </div>

    <div id="LadoDerecho">

        <h1>Registrase</h1>

        <form  id="formulario_registro" method="post" action="../controllers/controllers_user/controlador_usuario.php">
            
            <input type="hidden" name="seccion" value="Registrarse">
        
            <div class="campos">
                <label for="INombre">Nombre Completo</label>
                <input type="text" name="INombre" id="INombre">
            </div>

            <div class="campos">
                <label for="IIdentificacion">Cedula / RIF</label>
                <input type="text" name="IIdentificacion" id="IIdentificacion">
            </div>

            <div class="campos">
                <label for="IDireccion">Direccion</label>
                <input type="text" name="IDireccion" id="IDireccion">
            </div>

            <div class="campos">
                <label for="ICorreo">Correo Electronico</label>
                <input type="email" name="ICorreo" id="ICorreo">
            </div>

            <div class="campos">
                <label for="IContraseña">Contraseña</label>
                <input type="password" name="IContraseña" id="IContraseña">
            </div>

            <div>
                <p id="ErroresRegistro">
                    <?php echo isset($_SESSION["Registro"]["Error"]) ? $_SESSION["Registro"]["Error"] : ""; ?>
                </p>
            </div>

            <input type="submit" id="botonRegistrarse" value="Registrarse">
        </form>
    </div>  

    <script src="../public/scripts/mensaje.js"></script>
</body>
</html>