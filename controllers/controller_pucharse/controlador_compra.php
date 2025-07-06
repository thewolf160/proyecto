<?php
    session_start();
    require_once __DIR__ . '/../../models/models_pucharse/modelo_compra.php';

    $modeloCompra = new ModeloCompra();
    $modeloDetallesCompra = new ModeloDetallesCompra();
    $controladorCompra = new ControladorCompra();

    $Compra = new ControladorCompra();

    $seccion = htmlspecialchars($_POST["seccion"]);

    switch($seccion){
        case "ConsultarCompras":
            $_SESSION['usuario-root']['compras'] = $modeloDetallesCompra->M_NostrarCompras();
            header("Location: ../../root/ventas.php");
            exit();
        break;
    }

    class ControladorCompra{
        public function __construct(){}


        /* ESTA FUNCION ES PARA AGREGAR UNA COMPRA */
        public function AgregarCompra($datosCompra, $detallesCompra){
            global $modeloCompra;

            if($datosCompra["metodo_pago"]["efectivo"] || $datosCompra["metodo_pago"]["pago movil"] || $datosCompra["metodo_pago"]["credito"] || $datosCompra["metodo_pago"]["punto de venta"]){
                $datosCompra["estado"] = "pendiente";
            }
            return $modeloCompra->M_AgregarCompra($datosCompra, $detallesCompra);
        }


        /* ESTA FUNCION ES PARA CONSULTAR TODOS LOS DETALLES DE COMPRA */
        public function ConsultarCompras(){
            global $modeloDetallesCompra;
            return $modeloDetallesCompra->M_NostrarCompras();
        }


        /* ESTA FUNCION ES PARA CONFIRMAR UNA COMPRA */
        public function ConfirmarCompra($id){
            global $modeloCompra;
            return $modeloCompra->M_confirmarCompra($id);
        }
    }
?>