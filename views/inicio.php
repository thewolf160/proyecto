<?php session_start(); ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../public/css/inicio.css">
    <link rel="icon" type="image/png" href="../public/imagenes/icon.png">
    <title>PincOs - Inicio</title>
</head>
<body>
    <div id="navbar"></div>

    <section id="seccion-principal">
        <div id="contenido-principal">
            <h1>Bienvenido</h1>
            <p>Explora nuestra amplia gama de pinturas y encuntra la tonalidad ideal para tu proyecto.</p>
            <form id="formTodo" action="../controllers/controllers_product/controlador_producto.php" method="POST">
                <input type="hidden" name="seccion" value="Catalogo">
                <input type="hidden" name="categoria" value="Todo">
            </form>
            <a id="btnexplorar" onclick="document.getElementById('formTodo').submit();">Explorar</a>
        </div>
    </section>
   
    <section class="categorias">
        <article id="texto-categorias">
            <h3 id="Explorar">PARA CONSTRUIR Y DECORAR</h3>
            <p>!Lo tenemos todo!</p>
        </article>

        <div class="categoria domestica">
            <form id="formDomestica" action="../controllers/controllers_product/controlador_producto.php" method="POST">
                <input type="hidden" name="seccion" value="Catalogo">
                <input type="hidden" name="categoria" value="Domestica">
            </form>
            <a onclick="document.getElementById('formDomestica').submit();">
                <img src="../public/imagenes/domestica.jpg" alt="Domestica">
                <div class="texto-superpuesto">Domestica</div>
            </a>
        </div>


        <div class="categoria industrial">
            <form id="formIndustrial" action="../controllers/controllers_product/controlador_producto.php" method="POST">
                <input type="hidden" name="seccion" value="Catalogo">
                <input type="hidden" name="categoria" value="Industrial">
            </form>
            <a onclick="document.getElementById('formIndustrial').submit();">
                <img src="../public/imagenes/Industrial.jpg" alt="Industrial">
                <div class="texto-superpuesto">Industrial</div>
            </a>
        </div>

        <div class="categoria medera">
            <form id="formMadera" action="../controllers/controllers_product/controlador_producto.php" method="POST">
                <input type="hidden" name="seccion" value="Catalogo">
                <input type="hidden" name="categoria" value="Madera">
            </form>
            <a onclick="document.getElementById('formMadera').submit();">
                <img src="../public/imagenes/madera.jpg" alt="Madera">
                <div class="texto-superpuesto">Madera</div>
            </a>
        </div>

        <div class="categoria arquitectonica">
            <form id="formArquitectonica" action="../controllers/controllers_product/controlador_producto.php" method="POST">
                <input type="hidden" name="seccion" value="Catalogo">
                <input type="hidden" name="categoria" value="Arquitectonica">
            </form>
            <a onclick="document.getElementById('formArquitectonica').submit();">
                <img src="../public/imagenes/arquitectonica.jpg" alt="Arquitectonica">
                <div class="texto-superpuesto">Arquitectonica</div>
            </a>
        </div>

    </section>

    <section id="contacto">
        <form action="" id="formulario-contacto" method="POST">
            <input type="text" name="nombre" class="entrada nombre" placeholder="Nombre" id="nombre">
            <input type="text" name="apellido" class="entrada apellido" placeholder="Apellido" id="apellido">
            <input type="email" name="correo" class="entrada correo" placeholder="Correo Electrónico" id="correo">
            <textarea name="mensaje" class="entrada mensaje" placeholder="Mensaje" id="mensaje"></textarea>
            <button id="btn-formcontacto" onclick="Validacion()">Envíar Mensaje</button>
        </form>
        <article id="texto-contacto">
            <h3 style="text-align: center;">!CONTACTANOS!</h3>
            <p>¿Necesita ayuda para elegir la pintura perfecta?
                Dejanos tus datos y cúentanos en qué proyecto estás
                trabajando. Nuestros expertos te asesorarán
                sobre colores, tipos de pintura y cantidades necesarias.
                !Respondemos en menos de 24 horas!
            </p>
        </article>
    </section>


    <dialog id="modal-exito">
        <div class="modal-contenido">
            <p>El formulario se ha enviado correctamente.</p>
            <button id="btn-aceptar">Aceptar</button>
        </div>
    </dialog>

    <footer id="pie-pagina">
        <article class="seccion-footer">
            <h3>¿Sabes quién está detras de tus pinturas?</h3>
            <p>¡Conócenos! Aquí encontraras calidad,<br> amor por el detalle y colores que inspiran.</p>
        </article>
        <article class="seccion-footer">
            <h3>¡Conoces nuestros servicios!</h3>
            <p>En nuestra tienda, no solo vendemos pintura...<br>¡Te ayudamos a elegir la pintura perfecta</p>
        </article>
        <article class="seccion-footer">
            <h3>¡¡¡CONTACTANOS!!!</h3>
            <p>0416-4537225<br>0414-5026386</p>
            <p><a href="mailto:Todocolorlara@gmail.com">todocolorlara@gmail.com</a></p>
            <p>Carrera 19, entre calle 60 y 61</p>
        </article>
        <article class="parte-inferior">
            <p>&copy; 2025 Todo Color Lara. Todos los derechos reservados.</p>
        </article>
    </footer>

    <?php
        if(isset($_SESSION["Inicio_Sesion"]["usuario"])){
            echo "<script src='../public/scripts/navbar2.js'></script>";

        } else {
            echo "<script src='../public/scripts/navbar.js'></script>";
        }
    ?>

    <script src="../public/scripts/contacto.js"></script>
</body>
</html>