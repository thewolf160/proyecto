<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
    <title>PincOs-Inicio Sesiòn</title>
    <link rel="stylesheet" href="../public/css/inicio_sesion.css?v=1.0">
    <link rel="icon" type="image/png" href="../public/imagenes/icon.png">
</head>
<body>
    
    <a id="retroceder" href="inicio.php"><img src="../public/imagenes/Flechaatras1.png" alt="Flecha que te dirige al inicio"></a>

    <div id="inicioSesionDiv">
        <h1>Inicia Sesión</h1>

        <form action="../controllers/controllers_user/controlador_usuario.php" method="POST">
            <input type="hidden" name="seccion" value="inicio_sesion">

            <div id="CampoCorreo" class="Campo">
                <label for="ICorreo">Correo Electrónico</label><br>
                <input type="text" name="ICorreo">
            </div>
            
            <div id="CampoContraseña" class="Campo">
                <label for="IContraseña">Contraseña</label><br>
                <input type="password" name="IContraseña">
            </div>

            <a href="" id="M">¿Has olvidado tu contraseña?</a><br>

            <p id="Error">
                <?php echo isset($_SESSION["Inicio_Sesion"]["Error"]) ? $_SESSION["Inicio_Sesion"]["Error"] : "";
                    unset($_SESSION["Inicio_Sesion"]["Error"]);
                ?>
            </p>

            <div id="BtnMensajeIniciarSesion">
                <input type="submit" value="Iniciar Sesión"><br>
                <p>¿No tienes cuenta? <a href="registro.php">Registrate</a></p>
            </div>
        </form>
    </div>
    
    <div id="mensajeDiv">

        <p id="Hola">Hola,</p>
        <p id="Bienvenido">Bienvenido a PincOs</p>
        <p id="TuTienda">Tu tienda en linea de pinturas favoritas.</p>

    </div>
</body>
</html>