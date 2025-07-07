<?php 
    session_start(); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="../public/imagenes/icon.png">
     <link rel="stylesheet" href="../root/css/root.css">
    <title>Usuarios</title>
</head>
<body>
    <div id="aside"></div>
        <main id="usuarios">
            <h1>Usuarios Registrados</h1>
            <section id="busqueda2">
                <form action="../controllers/controllers_user/controlador_usuario.php" method="POST" id="form-busqueda2">
                    <input type="hidden" name="seccion" value="BarraBusqueda">
                    <input type="text" id="buscar2" name="IBusqueda" placeholder="Buscar..."/>
                    <button type="submit">Buscar</button>
                </form>
            </section> 
            
            <section id="Mostrar_Todos">
                <form id="formulario_usuarios" action="../controllers/controllers_user/controlador_usuario.php" method="POST">
                    <input type="hidden" name="seccion" value="MostrarTodos">
                    <input type="submit" value="Ver Todos" id="ver-todos">
                </form>
            </section>
            
            <table id="table-usuarios">
                <tr>
                    <th>Cédula</th>
                    <th>Nombre</th>
                    <th>Dirección</th>
                    <th id="correo">Correo</th>
                    <th>Fecha de Registro</th>
                </tr>
                <tbody>
                    <?php
                        if(isset($_SESSION["Error"])){
                            echo '<tr><td colspan="5" class="mensaje-vacio">No hay usuarios registrados</td></tr>';
                            unset($_SESSION["Error"]);
                        } else {
                            foreach ($_SESSION["usuario-root"]["usuarios"] as $fila) {  ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($fila['identificacion'] ?? ''); ?></td>
                                    <td><?php echo htmlspecialchars($fila['nombre'] ?? ''); ?></td>
                                    <td><?php echo htmlspecialchars($fila['direccion'] ?? ''); ?></td>
                                    <td><?php echo htmlspecialchars($fila['correo'] ?? ''); ?></td>
                                    <td><?php echo htmlspecialchars($fila['fecha_registro'] ?? ''); ?></td>
                                </tr>        
                            <?php }
                        } ?>
                </tbody>
            </table>
        </main>
    <script src="../root/js/aside.js"></script>
</body>
</html>