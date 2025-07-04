<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../root/css/root.css">
    <title>Usuarios</title>
</head>
<body>
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
                    <tr>
                        <td>31161696</td>
                        <td>Yonathan Nieles</td>
                        <td>El roble. Calle 3</td>
                        <td>yonathannieles011@gmail.com</td>
                        <td>12/04/20</td>
                    </tr>        
                </tbody>
            </table>
        </main>
    <script src="/root/js/aside.js"></script>
</body>
</html>