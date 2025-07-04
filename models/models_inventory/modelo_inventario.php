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


        /* ESTA FUNCION ES PARA MODIFICAR UN INVENTARIO */
        public function M_InventarioModificar($datos, $valor){
            global $operaciones;

            $inventario = $operaciones->Consultar("inventario", ["id" => $datos["id"]]);

            if($inventario !== null){
                if($valor === "Agregar"){
                    return $this->FechaEntrada($datos);
                } else if($valor === "Venta") {
                    return $this->FechaSalida($datos);
                
                } else {
                    $resultado = $operaciones->Modificar("inventario", $datos);
                    return empty($resultado) ? "ERROR: No se pudo modificar el inventario" : "Inventario modificado correctamente.";
                }
            } else {
                return "ERROR: No se pudo modificar el inventario. El stock no puede ser mayor al actual.";
            }
        }   


        /* ESTA FUNCION ES PARA ELIMINAR UN INVENTARIO */
        public function M_InventarioEliminar($datos){
            global $operaciones;
            $resultado = $operaciones->Modificar("inventario", $datos);
            return empty($resultado) ? "ERROR: No se pudo eliminar el inventario" : "Producto ELiminado del inventario correctamente.";
        }


        /* ESTA FUNCION ES PARA CONSULTAR UN INVENTARIO */
        public function M_InventarioConsultar($datos){
            global $operaciones;
            return $operaciones->Consultar("inventario", $datos);
        }


        /* ESTA FUNCION ES PARA COMPRAR */
        public function M_InventarioCompra($datos){
            global $operaciones;

            $inventario = $this->M_InventarioConsultar(["producto_id" => $datos["producto_id"]]);

            if(empty($inventario)) return "ERROR: No se pudo consultar el inventario";
                
            $inventario["stock"] = $inventario["stock"] - $datos["cantidad"];
            $inventario["fecha_ultima_salida"] = date('Y-m-d H:i:s');
            $resultado = $operaciones->Modificar("inventario", $inventario);

            return empty($resultado) ? "ERROR: No se pudo modificar el inventario" : "Inventario modificado correctamente.";
        }


        /* ESTA FUNCION ES PARA MODIFICAR LA FECHA DE ENTRADA */
        public function FechaEntrada($datos){
            global $operaciones;

            $datos["fecha_ultima_entrada"] = date('Y-m-d H:i:s');
            $resultado = $operaciones->Modificar("inventario", $datos);
            return empty($resultado) ? "ERROR: No se pudo modificar el inventario" : "Inventario modificado correctamente.";
        }


        /* ESTA FUNCION ES PARA MODIFICAR LA FECHA DE SALIDA */
        public function FechaSalida(){
            global $operaciones;

            $datos["fecha_ultima_salida"] = date('Y-m-d H:i:s');
            $resultado = $operaciones->Modificar("inventario", $datos);
            return empty($resultado) ? "ERROR: No se pudo modificar el inventario" : "Inventario modificado correctamente.";
        }
    }
?>