<?php
    require_once __DIR__ . '/../operaciones.php';

    $operaciones = new Operaciones("localhost", "root", "", "pincos");

    class ModeloInventario {

        public function __construct(){}

        /* ESTA FUNCION ES PARA AGREGAR UN INVENTARIO */
        public function M_InventarioAgregar($datos){
            global $operaciones;
        
            if($operaciones->Agregar("inventario", $datos) === true){
                return "Producto Agregado al inventario agregado correctamente.";
            } else {
                return "Error al agregar inventario";
            }
        }

        public function M_InventarioModificar($datos){
            global $operaciones;

            $inventario = $operaciones->Consultar("inventario", ["id" => $datos["id"]]);

            if($datos["stock"] > $inventario["stock"]){
                $datos["fecha_ultima_entrada"] = date('Y-m-d H:i:s');
                $resultado = $operaciones->Modificar("inventario", $datos);
            }

            return !$resultado || $resultado === null ? "ERROR: No se pudo modificar el inventario" : "Inventario modificado correctamente.";
        }   

        public function M_InventarioEliminar($datos){
            global $operaciones;
            $resultado = $operaciones->Modificar("inventario", $datos);
            return !$resultado || $resultado === null ? "ERROR: No se pudo eliminar el inventario" : "Producto ELiminado del inventario correctamente.";
        }
    }
?>