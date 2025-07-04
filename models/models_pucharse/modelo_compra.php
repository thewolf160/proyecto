<?php
    require_once __DIR__ . '/../operaciones.php';
    require_once __DIR__ . '/../models_pucharseDetails/modelo_detalleCompra.php';

    /*  */
    $operaciones = new Operaciones("localhost", "root", "", "pincos");
    $detalles_compra = new ModeloDetallesCompra();

    class ModeloCompra{
        public function __construct(){}

        public function M_AgregarCompra($datosCompra, $detallesCompra){
            global $operaciones;
            global $detalles_compra;

            $resultado = $operaciones->Agregar("compras", $datosCompra);

            if($resultado === true){
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

        public function M_ConsultarUna($datos){
            global $operaciones;
            $resultado = $operaciones->Consultar("compras", $datos);

            return $resultado;
        }
    }
?>