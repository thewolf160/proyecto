<?php session_start(); ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/css/carrito.css">
    <link rel="icon" type="image/png" href="../public/imagenes/icon.png">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
    <title>Carrito</title>
</head>
<body>
    <div id="navbar"></div>

    <main>
        <section id="items-carro" class="items-carro"></section>
        <section id="pedido">
            <div id="info-pago">
            <h3>Total a pagar:</h3>
            <span id="total">Bs</span>
            </div>
            <button id="pagar" onclick="abrirModalPagar()">Ir a pagar</button>
        </section>
    </main>
    <dialog id="seccion-pagar">
        <div id="contenido-pagar">
            <h3>Seleccione el método de pago</h3>
            <div class="metodo-pago">
                    <input type="checkbox" value="Pago movil" id="pago-movil" class="check" >
                    <label for="pago-movil">Pago Móvil</label>
            </div>
            <div class="metodo-pago">
                <input type="checkbox" value="Punto de Venta" id="punto-venta" class="check">
                <label for="punto-venta">Punto de Venta</label>
            </div>
            <div class="metodo-pago" >
                <input type="checkbox" value="Efectivo" id="efectivo" class="check">
                <label for="efectivo">Efectivo</label>
            </div>
            <div class="metodo-pago">
                <input type="checkbox" value="Credito" id="credito" class="check"> 
                <label for="credito">Credito</label>
            </div>
            <div id="botones-pago">
                <button>Aceptar</button>
                <button type="button" onclick="cerrarModalPagar()">Cancelar</button>
            </div>
        </div>
    </dialog>
    <dialog id="modulo-pagomovil">
        <div id="contenido-pagomovil">
            <article>
                <h3>Datos del Pago Móvil</h3>
                <p>CI-31161696</p>
                <p>0416-4537225</p>
                <p>0102-Venezuela</p>
            </article>
            <form action="" id="formulario-pago">
                <input type="text" placeholder="Número de Referencia">
            </form>
            <div id="btns-pagomovil">
                <button type="submit" form="formulario-pago">Enviar</button>
                <button type="button" onclick="cerrarModalPagomovil()">Cerrar</button>
            </div>
        </div>
    </dialog>
    <dialog id="modulo-otros">
        <div id="contenido-otros">
            <article>
                <h3>Gracias por su compra</h3>
                <p>Usted tiene 10 días hábiles para ir a retirar su pedido, de no asistir en el tiempo establecido su compra será anulada.</p>
            </article>
            <div id="btns-otros">
                <button type="submit">Aceptar</button>
                <button type="button" onclick="cerrarModalOtros()">Cancelar</button>
            </div>
        </div>
    </dialog>
    <script src="../public/scripts/carrito.js"></script>
    <script src="../public/scripts/modalPagar.js"></script>
    <script src="../public/scripts/checkbox.js"></script>   
    <?php
        if(isset($_SESSION["Inicio_Sesion"]["usuario"])){
            echo "<script src='../public/scripts/navbar2.js'></script>";

        } else {
            echo "<script src='../public/scripts/navbar.js'></script>";
        }
    ?>
</body>
</html>