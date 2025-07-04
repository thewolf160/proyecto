<?php

    require_once __DIR__ . '/../../models/models_pucharse/modelo_compra.php';

    $modeloCompra = new ModeloCompra();
    $modeloDetallesCompra = new ModeloDetallesCompra();

    class ControladorCarrito{
        public function __construct(){}

        public function AgregarProductos($datos, $detalles_compra){
            global $modeloCompra;
            global $modeloDetallesCompra;

            foreach($datos as $producto){
                $producto["estado"] = "en carrito";
                $resultado = $modeloCompra->M_AgregarCompra($producto, $detalles_compra);
                if(empty($resultado)) return "Error al agregar producto";
            }
        }
    }

?>