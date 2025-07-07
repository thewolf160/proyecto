<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../root/css/root.css">
    <link rel="stylesheet" href="../root/css/ventas.css">
    <link rel="icon" type="image/png" href="../public/imagenes/icon.png">
</head>
<body>
    <div id="aside"></div>
    <main id="compras-container"></main>

    <script>const comprasData = <?php echo json_encode($_SESSION['usuario-root']['compras'] ?? []); ?>;</script>
    <script src="../root/js/ventas.js"></script>
    <script src="../root/js/aside.js"></script>
</body>
</html>