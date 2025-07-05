<?php 
    session_start(); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../root/css/root.css">
    <title>Usuarios</title>
</head>
<body>

    <form id="formulario_usuarios" action="../controllers/controllers_user/controlador_usuario.php" method="POST">
        <input type="hidden" name="seccion" value="MostrarTodos">
    </form>

    <div id="aside"></div>
        <main id="usuarios">
            <h1>Usuarios Registrados</h1>
            <section id="busqueda">
                <form id="form-busqueda">
                    <input type="text" id="buscar" name="buscar" placeholder="Buscar..." hidden usuario-root/>
                    <button type="submit">Buscar</button>
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
                        if(!isset($_SESSION["usuario-root"]["usuarios"])){
                            echo '<p class="mensaje-vacio">No hay usuarios</p>';
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
    <script src="/root/js/aside.js"></script>
    <script>
        window.addEventListener('load', function() {
            if (!sessionStorage.getItem('formulario_enviado')) {
                document.getElementById('formulario_usuarios').submit();
                sessionStorage.setItem('formulario_enviado', 'true'); 
            }
        });
    </script>
</body>
</html>