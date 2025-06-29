<?php

require_once __DIR__ . '/../operaciones.php';

$operaciones = new Operaciones("localhost", "root", "", "pincos");

class ModeloCompra {
    public function __construct(){}

    // Buscar un usuario por ID (esto ya lo usás para obtener el correo)
    public function ObtenerCliente($usuarioId) {
        global $operaciones;
        return $operaciones->Existe("usuarios", ["id" => $usuarioId]);
    }

    // Agregar una compra y sus productos asociados
    public function RegistrarCompra($datosCompra, $productos) {
        global $operaciones;

        var_dump($datosCompra);

        $res = $operaciones->Agregar("compras", $datosCompra);

        if (!$res["exito"]) {
            return ["error" => $res["error"], "exito" => false];
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

            $nombre = $operaciones->Existe("productos", ["id" => $producto["producto_id"]]);

            $detalles[] = [
                "producto" => $nombre["nombre"] ?? "Producto",
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
