<?php
require_once __DIR__ . '/../operaciones.php';

$operaciones = new Operaciones("localhost", "root", "", "pincos");

class ModeloCompra {
    public function __construct(){}

    // Buscar un usuario por ID (esto ya lo usás para obtener el correo)
    public function ObtenerCliente($usuarioId) {
        global $operaciones;
        return $operaciones->Consultar("usuarios", ["id" => $usuarioId]);
    }

    // Agregar una compra y sus productos asociados
    public function RegistrarCompra($datosCompra, $productos) {
        global $operaciones;

        var_dump($datosCompra);

        $res = $operaciones->Agregar("compras", $datosCompra);
        var_dump($res);

        if ($res !== true && (!is_array($res) || !$res["exito"])) {
            $errorMsg = is_array($res) && isset($res["error"]) ? $res["error"] : "Error desconocido al guardar compra.";
            return ["error" => $errorMsg, "exito" => false];
        }



        $compraId = $operaciones->obtenerUltimoId();


        $detalles = [];

        foreach ($productos as $producto) {
            $producto["compra_id"] = $compraId;
            $subtotal = $producto["cantidad"] * $producto["precio_unitario"];

            $ok = $operaciones->Agregar("detalle_compras", $producto);
            if (!$ok) {
                return ["error" => "Error al registrar un producto", "exito" => false];
            }

            $nombre = $operaciones->Consultar("productos", ["id" => $producto["producto_id"]]);
            $nombresafe = is_array($nombre)? $nombre : [];
            $nombreProducto = $nombresafe["nombre"] ?? "Producto no encontrado";

            $detalles[] = [
                "producto" => $nombreProducto,
                "cantidad" => $producto["cantidad"],
                "precio_unitario" => $producto["precio_unitario"],
                "subtotal" => $subtotal
            ];
        }

        return [
            "exito" => true,
            "compra_id" => $compraId,
            "detalles" => $detalles
        ];
    }
}