<?php
    require_once __DIR__ . '/../operaciones.php';
    require_once __DIR__ . '/../models_pucharseDetails/modelo_detalleCompra.php';
    require_once __DIR__ . '/../models_inventory/modelo_inventario.php';

    /*  */
    $operaciones = new Operaciones("localhost", "root", "", "pincos");
    $detalles_compra = new ModeloDetallesCompra();
    $modelo_inventario = new ModeloInventario();

    class ModeloCompra{
        public function __construct(){}


        /* ESTA FUNCION ES PARA AGREGAR UNA COMPRA */
        public function M_AgregarCompra($datosCompra, $detallesCompra){
            global $operaciones;
            global $detalles_compra;

            $resultado = $operaciones->Agregar("compras", $datosCompra);

            if($resultado){
                $compra = $this->M_ConsultarUna(["usuario_id" => $datosCompra["usuario_id"]]);

                if(empty($compra)) return "ERROR: No se pudo consultar la compra";

                foreach($detallesCompra as &$detalle){  $detalle["compra_id"] = $compra["id"];  }
                unset($detalle);

                $resultado = $detalles_compra->AgregarDetallesCompra($detallesCompra);
                return !$resultado ? "Error al agregar detalles de compra" : $resultado;
                
            } else {
                return "Error al agregar compra";
            }
        }


        /* ESTA FUNCION ES PARA CONSULTAR UNA COMPRA */
        public function M_ConsultarUna($datos){
            global $operaciones;
            $resultado = $operaciones->Consultar("compras", $datos);

            return $resultado;
        }


        /* ESTA FUNCION ES PARA CONFIRMAR UNA COMPRA */
        public function M_confirmarCompra($id){
            global $operaciones;
            global $modelo_inventario;
            global $detalles_compra;

            $compra = $this->M_ConsultarUna(["usuario_id" => $id]);
            if(empty($compra)) return "ERROR: No se pudo consultar la compra";

            $compra["estado"] = "confirmado";
            $resultado = $operaciones->Modificar("compras", $compra);

            if(!empty($resultado)) {
                $detalles = $detalles_compra->M_ConsultarDetalles(["compra_id" => $compra["id"]]);

                foreach($detalles as $unidad){
                    $x = $modelo_inventario->M_InventarioConsultar(["producto_id" => $unidad["producto_id"]]);
                    $x["fecha_ultima_salida"] = date('Y-m-d H:i:s');

                    $resultado = $modelo_inventario->M_InventarioModificar($x, "Venta");
                }
            } else {
               return "Error al agregar detalles de compra.";
            } 
            return empty($resultado) ? "ERROR: No se pudo modificar la compra" : "Compra confirmada correctamente.";
        }

    }
?>