<?php
    require_once __DIR__ . '/../../models/models_pucharse/modelo_compra.php';

    $modeloCompra = new ModeloCompra();
    $modeloDetallesCompra = new ModeloDetallesCompra();
    $controladorCompra = new ControladorCompra();

    $Compra = new ControladorCompra();

    

    class ControladorCompra{
        public function __construct(){}

        public function AgregarCompra($datosCompra, $detallesCompra){
            global $modeloCompra;

            if($datosCompra["metodo_pago"]["efectivo"] || $datosCompra["metodo_pago"]["pago movil"] || $datosCompra["metodo_pago"]["credito"] || $datosCompra["metodo_pago"]["punto de venta"]){
                $datosCompra["estado"] = "pendiente";
            
            } else {
                  // LOGICA DEL CORREO
            }
            return $modeloCompra->M_AgregarCompra($datosCompra, $detallesCompra);
        }

        public function ConsultarCompras(){
            global $modeloDetallesCompra;
            return $modeloDetallesCompra->M_NostrarCompras();
        }
    }
?>